<template>
    <div class="search-body mt-4">
        <search-header
            :query="query"
            :view-type="listView"
            @on-view-click="view => (listView = view)"
            @on-search-select="onSearchSelect"
            @on-query-change="onQueryChange"
            :update-history="updateHistory"
        ></search-header>
        <div class="search-content">
            <div class="search-content-left">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="filter-results">
                        Filter results
                        <span class="result-desc">({{ paginatedData?.total || 0 }})</span>
                    </div>
                    <button
                        @click="resetFilter"
                        type="button"
                        class="reset-button"
                        :disabled="!filtersChanged"
                    >
                        Reset All
                    </button>
                </div>
                <div class="filter-card">
                    <div class="header">
                        <div class="title">Genre</div>
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </div>
                    <div class="popup">
                        <select
                            name="genere"
                            id="genere"
                            class="form-select"
                            v-model="filters.genre"
                            @change="navigate(prevUsedSearchUrl || null)"
                        >
                            <option :value="null">Select genere</option>
                            <option v-for="genere in filterData.genres" :key="genere.id" :value="genere.id">
                                {{ genere.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="filter-card">
                    <div class="header">
                        <div class="title">Author</div>
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </div>
                    <div class="popup">
                        <select
                            name="author"
                            id="author"
                            class="form-select"
                            v-model="filters.author"
                            @change="navigate(prevUsedSearchUrl || null)"
                        >
                            <option :value="null">Select author</option>
                            <option v-for="author in filterData.authors" :key="author.id" :value="author.id">
                                {{ author.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="filter-card">
                    <div class="header">
                        <div class="title">Publisher</div>
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </div>
                    <div class="popup">
                        <select
                            name="publisher"
                            id="publisher"
                            class="form-select"
                            v-model="filters.publisher"
                            @change="navigate(prevUsedSearchUrl || null)"
                        >
                            <option :value="null">Select publisher</option>
                            <option
                                v-for="publisher in filterData.publishers"
                                :key="publisher.id"
                                :value="publisher.id"
                            >
                                {{ publisher.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="filter-card">
                    <div class="header">
                        <div class="title">ISBN</div>
                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                    </div>
                    <div class="popup">
                        <select
                            name="isbn"
                            id="isbn"
                            class="form-select"
                            v-model="filters.isbn"
                            @change="navigate(prevUsedSearchUrl || null)"
                        >
                            <option :value="null">Select isbn</option>
                            <option v-for="isbn in filterData.isbns" :key="isbn.isbn" :value="isbn.isbn">
                                {{ isbn.isbn }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="search-content-right">
                <div v-if="apiInProgress" class="loading-spinner-container">
                    <i class="fa fa-circle-o-notch fa-spin fa-4x"></i>
                </div>
                <template v-else>
                    <div class="books-wrapper">
                        <template v-if="paginatedData?.data?.length > 0">
                            <book-card
                                v-for="book in paginatedData.data"
                                :book="book"
                                :list-view="listView"
                                :key="book.id"
                            ></book-card>
                        </template>
                        <div v-else>We didn't find any results for the search</div>
                    </div>
                    <search-pagination
                        :pagination="paginatedData"
                        @on-navigate="url => navigate(url)"
                    ></search-pagination>
                </template>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import SearchHeader from './SearchHeaderComponent.vue';
    import BookCard from '../BookCard.vue';
    import SearchPagination from './SearchPaginationComponent.vue';

    export default {
        components: {
            SearchHeader,
            BookCard,
            SearchPagination,
        },
        props: {
            queryProp: {
                type: String,
                required: true,
            },
            searchUrl: {
                type: String,
                required: true,
            },
            filterDataUrl: {
                type: String,
                required: true,
            },
        },
        data() {
            return {
                query: this.queryProp,
                listView: false,
                paginatedData: null,
                prevUsedSearchUrl: null,
                apiInProgress: false,
                filters: {
                    author: null,
                    genre: null,
                    publisher: null,
                    isbn: null,
                },
                filterData: {
                    authors: [],
                    genres: [],
                    publishers: [],
                    isbns: [],
                },
            };
        },
        methods: {
            navigate(url) {
                const { query, page } = this.extractQueryAndPage(url);
                const generatedUrl = this.generateUrl(this.filters, query, page);
                this.apiInProgress = true;

                axios
                    .get(generatedUrl)
                    .then(({ data }) => {
                        this.prevUsedSearchUrl = generatedUrl;
                        this.paginatedData = data;
                    })
                    .catch(error => {
                        console.log(error);
                        this.$toast.error('Something went wrong, please try again');
                    })
                    .finally(() => {
                        this.apiInProgress = false;
                    });
            },
            generateUrl(filters, query, page) {
                let url = `${this.searchUrl}?`;
                if (query) {
                    url += 'query=' + encodeURIComponent(query) + '&';
                }

                if (page) {
                    url += 'page=' + encodeURIComponent(page) + '&';
                }

                for (let key in filters) {
                    if (filters[key]) {
                        url += key + '=' + encodeURIComponent(filters[key]) + '&';
                    }
                }
                return url.slice(0, -1);
            },
            extractQueryAndPage(url) {
                console.log(url);
                let query = null;
                let page = null;
                let params = new URLSearchParams(new URL(url).search);
                if (params.has('query')) {
                    query = params.get('query');
                }
                if (params.has('page')) {
                    page = params.get('page');
                }
                return { query, page };
            },
            onSearchSelect(suggestion) {
                if (this.query != suggestion.title) {
                    this.query = suggestion.title;
                    this.navigate(`${this.searchUrl}${this.query ? `?query=${this.query}` : ''}`);
                }
            },
            resetFilter() {
                this.filters = {
                    author: null,
                    genre: null,
                    publisher: null,
                    isbn: null,
                };

                this.navigate(this.prevUsedSearchUrl);
            },
            updateHistory(title) {
                const { protocol, host, pathname } = window.location;

                let newUrl = protocol + '//' + host + pathname;

                if (title) {
                    newUrl += '?query=' + title;
                }

                if (history.pushState) {
                    window.history.pushState({ path: newUrl }, '', newUrl);
                }
            },
            onQueryChange(value) {
                this.query = value;

                if (this.query == '') {
                    this.updateHistory(this.query);
                    this.navigate(this.searchUrl);
                }
            },
            fetchDataForFilter() {
                this.apiInProgress = true;
                axios.get(this.filterDataUrl).then(({ data }) => {
                    console.log(data);
                    this.filterData = data;
                })
                .catch(err => {
                    console.log(error);
                }).finally(() => {
                    this.apiInProgress = false;
                });
            },
        },
        computed: {
            filtersChanged() {
                let changed = false;
                for (let key in this.filters) {
                    if (this.filters[key]) {
                        changed = true;
                    }
                }

                return changed;
            },
        },
        mounted() {
            this.navigate(`${this.searchUrl}${this.query ? `?query=${this.query}` : ''}`);
            this.fetchDataForFilter();
        },
    };
</script>

<style lang="scss" scoped>
    .search-body {
        .search-content {
            display: flex;
            .search-content-left {
                background-color: #fff;
                min-width: 385px;
                padding: 30px 15px 0 70px;
                .filter-results {
                    color: #454a55;
                    font-size: 18px;
                    line-height: 22px;
                }
                .reset-button {
                    background: none;
                    border: 0;
                    color: #4ac5e3;
                    font-size: 14px;
                    line-height: 16px;
                }
            }
            .search-content-right {
                align-items: flex-start;
                background-color: #dfe3eb;
                display: flex;
                flex-direction: column;
                flex-grow: 1;
                justify-content: space-between;
                min-height: calc(100vh - 170px);
            }
            .books-wrapper {
                align-content: flex-start;
                display: flex;
                flex-wrap: wrap;
                justify-content: flex-start;
                padding: 30px 30px 10px;
                width: 100%;
            }
            .pagination-wrapper {
                display: flex;
                justify-content: center;
                margin-bottom: 60px;
                width: 100%;
            }
        }
    }

    .result-desc {
        color: #6d737d;
    }

    .filter-card {
        background: #f5f6fa;
        border-radius: 10px;
        margin-bottom: 1rem;
        width: 295px;

        .header {
            align-items: center;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
        }

        .popup {
            padding: 0 20px 20px;
        }
    }

    .loading-spinner-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        color: var(--orange2);
    }
</style>
