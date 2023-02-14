<template>
    <div class="table-responsive">
        <div class="text-end mb-3">
            <button type="button" class="btn btn-outline-primary" @click="isModalOpen = true">
                <i class="fa fa-plus"></i> New {{ label }}
            </button>
        </div>
        <table
            ref="dataTableRef"
            class="table table-striped table-borderless"
            style="padding: 10px 6px"
        >
            <thead class="bg-success text-white">
                <tr>
                    <th class="dont-show">id</th>
                    <th class="text-capitalize">{{ label }}</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot class="bg-success text-white">
                <tr>
                    <th class="dont-show">id</th>
                    <th class="text-capitalize">{{ label }}</th>
                    <th>Created</th>
                    <th>Updated</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <name-form
        :label="label"
        :storeUrl="storeUrl"
        :showUrl="showUrl"
        :updateUrl="updateUrl"
        :subjectId="selectedId"
        :isOpen="isModalOpen"
        :onClose="onModalClose"
        :onFormSubmitted="onFormSubmit"
    />
    <confirm-dialog
        :message="`Are you certain you wish to delete this ${label}? This action cannot be undone.`"
        :confirmHandler="onDelete"
        :cancelHandler="onCancelDelete"
        ref="confirmModal"
    />
</template>

<script>
    import axios from 'axios';
    import NameForm from './NameForm.vue';
    import ConfirmDialog from './common/ConfirmDialogComponent.vue';
    export default {
        props: {
            label: {
                type: String,
                required: true,
            },
            dataSourceUrl: {
                type: String,
                required: true,
            },
            deleteUrl: {
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
        },
        components: {
            NameForm,
            ConfirmDialog,
        },
        data() {
            return {
                tableInstance: null,
                dataTableConfig: {
                    pagingType: 'full_numbers',
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    sort: false,
                    info: true,
                    ajax: this.dataSourceUrl,
                    fixedHeader: {
                        header: true,
                        footer: false,
                    },
                    autoWidth: false,
                    language: {
                        processing:
                            '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'name' },
                        { data: 'created_at' },
                        { data: 'updated_at' },
                        { data: 'action' },
                    ],
                    columnDefs: [
                        {
                            width: '30%',
                            targets: [1],
                        },
                        {
                            width: '20%',
                            targets: [2, 3, 4],
                        },
                        {
                            className: 'dt-right',
                            targets: [4],
                        },
                        {
                            targets: 'dont-show',
                            visible: false,
                        },
                    ],
                },
                selectedId: null,
                isModalOpen: false,
                deleteId: null,
            };
        },
        methods: {
            refreshTable() {
                if (this.tableInstance) {
                    this.tableInstance.destroy();
                }

                this.tableInstance = $(this.$refs.dataTableRef).DataTable(this.dataTableConfig);
            },
            onModalClose() {
                this.isModalOpen = false;
                this.selectedId = null;
            },
            onFormSubmit() {
                this.refreshTable();
                this.isModalOpen = false;
                this.selectedId = null;
            },
            listenForEdit(params) {
                if (params?.id) {
                    this.selectedId = params.id;
                    this.isModalOpen = true;
                }
            },
            confirmDelete(params) {
                if (params?.id) {
                    this.deleteId = params.id;
                    this.$refs.confirmModal.showModal = true;
                }
            },
            onCancelDelete() {
                this.$refs.confirmModal.showModal = false;
            },
            onDelete() {
                if (this.deleteId) {
                    axios
                        .delete(this.deleteUrl.replace(':id', this.deleteId))
                        .then(({ data }) => {
                            this.deleteId = null;
                            this.$toast.success(data.message);
                            this.refreshTable();
                        })
                        .catch(error => {
                            console.log(error);
                            this.$toast.error('Something went wrong, please try again');
                        })
                        .finally(() => {
                            this.$refs.confirmModal.showModal = false;
                        });
                }
            },
        },
        mounted() {
            this.refreshTable();
            CustomEvent.listen('refresh-table-list', this.refreshTable);
            CustomEvent.listen(`edit-${this.label}-event`, this.listenForEdit);
            CustomEvent.listen(`delete-${this.label}-event`, this.confirmDelete);
        },
    };
</script>

<style></style>
