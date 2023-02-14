<template>
    <div class="search-header">
        <div class="d-flex align-items-center">
            <div class="search-input-wrapper mr-2">
                <div class="search-input" id="search-input">
                    <input
                        ref="searchInput"
                        type="search"
                        placeholder="Search title"
                        :value="query"
                        @input="onSearchInput"
                    />
                    <i class="fa fa-search search-icon"></i>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <button type="button" class="image-button mx-2" @click="$emit('onViewClick', false)">
                <i class="fa fa-th-large" :class="{ active: !viewType }" aria-hidden="true"></i>
            </button>
            <button type="button" class="image-button mx-2" @click="$emit('onViewClick', true)">
                <i class="fa fa-list" :class="{ active: viewType }" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            query: {
                type: String,
                required: true,
            },
            viewType: {
                type: Boolean,
                required: true,
            },
            updateHistory: {
                type: Function,
                required: true,
            }
        },
        data() {
            return {
                lastSearch: null,
            };
        },
        methods: {
            initTypeAhead() {
                const self = this;
                const searchField = $(this.$refs.searchInput);

                // Set up Bloodhound
                const books = new Bloodhound({
                    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
                    queryTokenizer: Bloodhound.tokenizers.whitespace,
                    identify: obj => obj.id,
                    remote: {
                        url: '/search-title?query=%QUERY',
                        wildcard: '%QUERY',
                    },
                });

                // Set up Typeahead
                searchField.typeahead(
                    {
                        minLength: 2,
                        highlight: true,
                    },
                    {
                        name: 'books',
                        display: 'title',
                        source: books,
                        templates: {
                            empty: [
                                '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>',
                            ],
                            header: ['<div class="list-group search-results-dropdown">'],
                            suggestion: data => {
                                return '<a href="javascript:void(0)" class="list-group-item">' + data.title + '</a>';
                            },
                        },
                    }
                );

                searchField.bind('typeahead:select', function (ev, suggestion) {
                    // This will clear the suggestions on focus
                    self.onSuggestionSelect(ev, suggestion);
                });
            },
            onSuggestionSelect(ev, suggestion) {
                this.updateHistory(suggestion.title);
                this.$emit('on-search-select', suggestion);
            },
            onSearchInput(e) {
                // this.updateHistory(this.query);
                this.$emit('on-query-change', e.target.value);
                if (this.query == '') {
                    this.updateHistory(this.query);
                }
            }
        },
        mounted() {
            this.initTypeAhead();
        },
    };
</script>

<style lang="scss" scoped>
    .search-input {
        input {
            background-color: #fff;
            border: 0;
            border-radius: 20px;
            box-shadow: 0 5px 28px 0 rgba(0, 0, 0, 0.15);
            color: #a8adb5;
            font-size: 14px;
            line-height: 16px;
            padding: 12px 45px 12px 20px;
            width: 300px;
        }
        .search-icon {
            position: absolute;
            right: 21px;
            top: 12px;
            color: var(--orange1);
        }
    }

    .search-header {
        align-items: center;
        background-color: #fff;
        border-bottom: 1px solid #dfe3eb;
        display: flex;
        height: 100px;
        justify-content: space-between;
        padding: 10px 70px;
        .search-input-wrapper {
            position: relative;
            .search-input {
                min-width: 300px;
                z-index: 5;
                &.active {
                    background-color: #fff;
                    border-top-left-radius: 20px;
                    border-top-right-radius: 20px;

                    input {
                        border-radius: 20px;
                        color: #454a55;
                    }
                }
                input {
                    background-color: #e9e9e9;
                    outline: none;
                    box-shadow: none;
                    width: 580px;
                }

                .search-icon {
                    right: 12px;
                }
            }
        }

        .image-button {
            background-color: transparent;
            border: 0;
            margin: 0;
            padding: 0;
            i {
                color: #a8adb5;
                font-size: 30px;
                padding: 5px 3px 3px;
            }
            .active {
                color: var(--orange1);
            }
        }
    }
</style>
