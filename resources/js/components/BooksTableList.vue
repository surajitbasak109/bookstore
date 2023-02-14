<template>
    <div class="table-responsive">
        <table
            ref="dataTableRef"
            class="table table-striped table-borderless"
            style="padding: 10px 6px"
        >
            <thead class="bg-info text-white">
                <tr>
                    <th class="dont-show">id</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Description</th>
                    <th>ISBN</th>
                    <th>Publisher</th>
                    <th>Published On</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot class="bg-info text-white">
                <tr>
                    <th class="dont-show">id</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Description</th>
                    <th>ISBN</th>
                    <th>Publisher</th>
                    <th>Published On</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <confirm-dialog
        :message="`Are you certain you wish to delete this book? This action cannot be undone.`"
        :confirmHandler="onDelete"
        :cancelHandler="onCancelDelete"
        ref="confirmModal"
    />
</template>

<script>
    import axios from 'axios';
    import ConfirmDialog from './common/ConfirmDialogComponent.vue';
    export default {
        props: {
            dataSourceUrl: {
                type: String,
                required: true,
            },
            deleteUrl: {
                type: String,
                required: true,
            },
        },
        components: {
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
                        { data: 'title' },
                        { data: 'author_name' },
                        { data: 'genre_name' },
                        { data: 'short_description' },
                        { data: 'isbn' },
                        { data: 'publisher_name' },
                        { data: 'published_human' },
                        { data: 'action' },
                    ],
                    columnDefs: [
                        {
                            width: '8%',
                            targets: [1, 2, 3, 5, 6, 8],
                            className: 'dt-center',
                        },
                        {
                            width: '20%',
                            targets: [4],
                            className: 'dt-center',
                        },
                        {
                            width: '10%',
                            targets: [7],
                            className: 'dt-center',
                        },
                        {
                            targets: 'dont-show',
                            visible: false,
                        },
                    ],
                },
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
            CustomEvent.listen(`delete-book-event`, this.confirmDelete);
        },
    };
</script>

<style></style>
