<template>
    <div>
        <div class="modal fade show" tabindex="-1" role="dialog" v-bind:class="{ 'd-block': showModal }">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm</h5>
                        <button type="button" class="btn-close" @click="cancelHandler"></button>
                    </div>
                    <div class="modal-body">
                        <p>{{ message }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" @click="confirmHandler">
                            Confirm
                        </button>
                        <button type="button" class="btn btn-outline-secondary" @click="cancelHandler">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModal" class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
    export default {
        props: {
            message: {
                type: String,
                required: true,
            },
            confirmHandler: {
                type: Function,
                required: true,
            },
            cancelHandler: {
                type: Function,
                required: true,
            },
        },
        data() {
            return {
                showModal: false,
            };
        },
    };
</script>
