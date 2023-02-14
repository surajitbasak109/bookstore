<template>
    <div v-if="isOpen">
        <div class="modal fade show d-block" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            {{ formData.id ? 'Edit' : 'Create' }}
                            <span class="text-capitalize">{{ label }}</span>
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            aria-label="Close"
                            @click="onModalClose"
                        ></button>
                    </div>
                    <form @submit.prevent="onFormSubmit">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label text-capitalize">{{ label }} name</label>
                                <input
                                    id="nameInputField"
                                    type="text"
                                    class="form-control"
                                    :class="{ 'is-invalid': nameError }"
                                    v-model="formData.name"
                                />
                                <div v-if="nameError" class="invalid-feedback">
                                    {{ nameError }}
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                @click="onModalClose"
                                class="btn btn-secondary"
                                data-bs-dismiss="modal"
                            >
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary" :disabled="apiInProgress">
                                <i v-if="apiInProgress" class="fa fa-spinner fa-spin fa-fw"></i>
                                <i v-else class="fa fa-save fa-fw"></i>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        props: {
            label: {
                type: String,
                required: true,
            },
            storeUrl: {
                type: String,
                required: true,
            },
            showUrl: {
                type: String,
                required: true,
            },
            updateUrl: {
                type: String,
                required: true,
            },
            isOpen: {
                type: Boolean,
                required: true,
            },
            onClose: {
                type: Function,
                required: true,
            },
            onFormSubmitted: {
                type: Function,
                required: true,
            },
            subjectId: {
                type: Number,
            },
        },
        data() {
            return {
                formData: {
                    id: null,
                    name: null,
                },
                nameError: null,
                apiInProgress: false,
            };
        },
        methods: {
            onFormSubmit() {
                if (this.subjectId) {
                    this.update(this.subjectId);
                } else {
                    this.store();
                }
            },
            fetchAuthor(id) {
                axios.get(this.showUrl.replace(':id', id)).then(({ data }) => {
                    this.formData = data;
                });
            },
            store() {
                this.apiInProgress = true;
                const formData = { name: this.formData.name };

                axios
                    .post(this.storeUrl, formData)
                    .then(({ data }) => {
                        this.$toast.success(data.message);
                        this.resetData();
                        this.onFormSubmitted();
                    })
                    .catch(error => {
                        console.log(error);
                        this.nameError = error.response.data.message;
                        this.$toast.error('Validation failed');
                    })
                    .finally(() => {
                        this.apiInProgress = false;
                    });
            },
            update(id) {
                this.apiInProgress = true;
                const formData = { name: this.formData.name };

                axios
                    .put(this.updateUrl.replace(':id', id), formData)
                    .then(({ data }) => {
                        this.$toast.success(data.message);
                        this.resetData();
                        this.onFormSubmitted();
                    })
                    .catch(error => {
                        console.log(error);
                        this.nameError = error.response.data.message;
                        this.$toast.error('Validation failed');
                    })
                    .finally(() => {
                        this.apiInProgress = false;
                    });
            },
            onModalClose() {
                this.resetData();
                this.onClose();
            },
            resetData() {
                this.nameError = null;
                this.formData = { id: null, name: null };
            },
        },
        mounted() {
        },
        watch: {
            subjectId(newValue) {
                if (newValue) {
                    this.fetchAuthor(this.subjectId);
                } else {
                    this.formData = {
                        id: null,
                        name: null,
                    };
                    this.nameError = null;
                }
            },
        },
    };
</script>

<style></style>
