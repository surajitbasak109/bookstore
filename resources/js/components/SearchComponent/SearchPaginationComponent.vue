<template>
    <div v-if="pagination?.last_page > 1" class="pagination-wrapper" style="margin-top: 20px">
        <nav>
            <ul class="pagination">
                <li :key="'prev'">
                    <a
                        v-if="pagination.prev_page_url"
                        @click.prevent="$emit('onNavigate', pagination.first_page_url)"
                        href="#"
                    >
                        First
                    </a>
                    <span v-else> First </span>
                </li>

                <li v-for="link in pagination.links" :key="link.label">
                    <a
                        :class="{ active: link.active }"
                        v-if="link.url"
                        @click.prevent="$emit('onNavigate', link.url)"
                        v-html="link.label"
                        href="#"
                    ></a>
                    <span v-else v-html="link.label"></span>
                </li>
                <li v-if="pagination.next_page_url" :key="'last'">
                    <a @click.prevent="$emit('onNavigate', pagination.last_page_url)" href="#">
                        Last
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        props: ['pagination'],
    };
</script>

<style lang="scss" scoped>
    .pagination {
        li {
            a {
                text-decoration: none;
                &.active {
                    color: #a8adb5;
                    font-weight: 700;
                }
            }
            a,
            span {
                background: none;
                border: none;
                color: #4ac5e3;
                cursor: pointer;
                font-size: 20px;
                padding: 5px 10px;
                -webkit-user-select: none;
                -moz-user-select: none;
                -ms-user-select: none;
                user-select: none;
            }

            span {
                color: #a8adb5;
                cursor: default;
            }
        }
    }
</style>
