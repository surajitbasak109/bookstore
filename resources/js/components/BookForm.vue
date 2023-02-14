<template>
    <div class="card">
        <div class="card-body">
            <form @submit.prevent="onFormSubmit" ref="bookForm">
                <div class="row mb-3">
                    <div :class="book.id ? 'col-md-3' : 'col-md-4'">
                        <label for="title" class="form-label">Title</label>
                        <input
                            type="text"
                            v-model="book.title"
                            id="title"
                            name="title"
                            class="form-control"
                            placeholder="Enter title"
                            :class="{ 'is-invalid': bookApiError.title }"
                            :autofocus="!book.id"
                        />
                        <div v-if="bookApiError.title" class="invalid-feedback">
                            {{ bookApiError.title }}
                        </div>
                    </div>
                    <div :class="book.id ? 'col-md-3' : 'col-md-4'">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input
                            type="text"
                            class="form-control"
                            :class="bookApiError.isbn ? 'is-invalid' : ''"
                            id="isbn"
                            name="isbn"
                            placeholder="Enter ISBN"
                            v-model="book.isbn"
                            v-mask="{ mask: 'NNN-N-NN-NNNNNN-N', model: 'book.isbn' }"
                        />
                        <div v-if="bookApiError.isbn" class="invalid-feedback">
                            {{ bookApiError.isbn }}
                        </div>
                    </div>
                    <div :class="book.id ? 'col-md-3' : 'col-md-4'">
                        <label for="image" class="form-label">Image</label>
                        <input
                            type="file"
                            class="form-control"
                            :class="bookApiError.image ? 'is-invalid' : ''"
                            id="image"
                            name="image"
                            accept="image/x-png,image/gif,image/jpeg"
                        />
                        <div v-if="bookApiError.image" class="invalid-feedback">
                            {{ bookApiError.image }}
                        </div>
                    </div>
                    <div v-if="book.id" class="col-md-3">
                        <label for="published" class="form-label">Published</label>
                        <input
                            type="date"
                            ref="dateInput"
                            class="form-control"
                            :class="bookApiError.published ? 'is-invalid' : ''"
                            id="published"
                            name="published"
                            v-model="book.published"
                        />
                        <div v-if="bookApiError.published" class="invalid-feedback">
                            {{ bookApiError.published }}
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="author" class="form-label">Author</label>
                        <select2
                            @select="onAuthorSelect($event)"
                            id="author"
                            v-model="book.author_id"
                            :options="authors"
                            name="author_id"
                            placeholder="Select author"
                            :class="{ 'is-invalid': bookApiError.author_id }"
                        ></select2>
                        <div v-if="bookApiError.author_id" class="invalid-feedback">
                            {{ bookApiError.author_id }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="genre" class="form-label">Genre</label>
                        <select2
                            @select="onGenreSelect"
                            id="genre"
                            v-model="book.genre_id"
                            name="genre_id"
                            :options="genres"
                            placeholder="Select genre"
                            :class="{ 'is-invalid': bookApiError.genre_id }"
                        ></select2>
                        <div v-if="bookApiError.genre_id" class="invalid-feedback">
                            {{ bookApiError.genre_id }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="genre" class="form-label">Publisher</label>
                        <select2
                            @select="onPublisherSelect"
                            id="publisher"
                            name="publisher_id"
                            v-model="book.publisher_id"
                            :options="publishers"
                            placeholder="Select publisher"
                            :class="{ 'is-invalid': bookApiError.publisher_id }"
                        ></select2>
                        <div v-if="bookApiError.publisher_id" class="invalid-feedback">
                            {{ bookApiError.publisher_id }}
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea
                            type="text"
                            v-model="book.description"
                            id="description"
                            name="description"
                            class="form-control"
                            placeholder="Enter Description"
                            rows="5"
                            :class="{ 'is-invalid': bookApiError.description }"
                        />
                        <div v-if="bookApiError.description" class="invalid-feedback">
                            {{ bookApiError.description }}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-lg-end text-sm-center">
                        <button
                            type="submit"
                            class="btn btn-outline-primary"
                            :disabled="apiInProgress"
                        >
                            <i v-if="apiInProgress" class="fa fa-spinner fa-spin fa-fw"></i>
                            <i v-else class="fa fa-"></i>
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue';
    import axios from 'axios';
    import Select2 from './common/Select2Component.vue';
    import { VMaskDirective } from 'v-slim-mask';
    export default defineComponent({
        directives: {
            mask: VMaskDirective,
        },
        components: {
            Select2,
        },
        props: {
            bookProp: {
                type: Object,
            },
            authors: {
                type: Array,
                required: true,
            },
            genres: {
                type: Array,
                required: true,
            },
            publishers: {
                type: Array,
                required: true,
            },
            storeUrl: {
                type: String,
            },
            updateUrl: {
                type: String,
            },
        },
        data() {
            return {
                book: {
                    id: null,
                    title: null,
                    description: null,
                    isbn: null,
                    image: null,
                    published: null,
                    author_id: null,
                    genre_id: null,
                    publisher_id: null,
                },
                bookApiError: {
                    title: null,
                    description: null,
                    isbn: null,
                    image: null,
                    published: null,
                    author_id: null,
                    genre_id: null,
                    publisher_id: null,
                },
                apiInProgress: false,
                isbnMaskOption: {
                    mask: '###-#-##-######-#',
                    eager: true,
                },
            };
        },
        methods: {
            clearErrors() {
                this.bookApiError = {
                    title: null,
                    description: null,
                    isbn: null,
                    image: null,
                    published: null,
                    author_id: null,
                    genre_id: null,
                    publisher_id: null,
                };
            },
            onFormSubmit() {
                this.clearErrors();

                const formData = new FormData(this.$refs.bookForm);

                const url = this.book.id
                    ? this.updateUrl.replace(':id', this.book.id)
                    : this.storeUrl;

                this.apiInProgress = true;

                axios
                    .post(url, formData)
                    .then(({ data }) => {
                        this.$toast.success(data.message + ' Redirecting...');
                        setTimeout(() => (window.location.href = '/books'), 800);
                    })
                    .catch(error => {
                        console.log(error);
                        if (error?.response) {
                            if (error.response.status == 422) {
                                this.$toast.error(
                                    'Validation failed: ' + error.response.data.message
                                );

                                this.showValidationError(error.response.data.errors);
                            } else {
                                this.$toast.error('Something went wrong, please try again');
                            }
                        } else {
                            this.$toast.error('Unknown error');
                        }
                    })
                    .finally(() => {
                        this.apiInProgress = false;
                    });
            },
            showValidationError(errors) {
                for (let error in errors) {
                    this.bookApiError[error] = errors[error].join(',');
                }
            },
            onGenreSelect(event) {
                console.log(event);
            },
            onAuthorSelect(event) {
                console.log(event);
            },
            onPublisherSelect(event) {
                console.log(event);
            },
        },
        mounted() {
            if (this.bookProp) {
                this.book = JSON.parse(JSON.stringify(this.bookProp));
            }

            // $(this.$refs.isbnInputRef).inputmask('999-9-99-999999-9');
        },
    });
</script>

<style></style>
