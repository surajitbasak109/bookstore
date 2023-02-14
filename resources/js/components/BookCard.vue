<template>
    <div :class="{ 'book-card': !listView, 'book-list-view': listView }">
        <a :href="`${baseUrl}/book-detail/${book.id}`" target="_blank">
            <img :src="book.image_url" alt="book image" class="book-image" />
        </a>
        <a :href="`${baseUrl}/book-detail/${book.id}`" target="_blank" :class="{ left: listView }">
            <div :class="{ 'book-card__content': !listView, 'd-flex flex-column': listView }">
                <div class="book-title mb-3">{{ book.title }}</div>
                <div class="book-desc mb-3">
                    {{ listView ? book.description : book.short_description }}
                </div>
                <div class="book-isbn">ISBN: {{ book.isbn }}</div>
                <div class="book-author">By {{ book.author_name }}</div>
            </div>
        </a>
        <a :href="`${baseUrl}/book-detail/${book.id}`" target="_blank">
            <div :class="{ right: listView }">
                <div class="book-footer">
                    <div :class="{ 'my-4': listView }">
                        <span v-if="listView">Published in </span>{{ book.published_short }}
                    </div>
                    <div><span v-if="listView">Publisher: </span> {{ book.publisher_name }}</div>
                </div>
            </div>
        </a>
    </div>
</template>

<script>
    export default {
        props: {
            book: {
                type: Object,
                required: true,
            },
            listView: {
                type: Boolean,
                required: true,
            },
        },
        data() {
            return {
                baseUrl: window.BASE_URL,
            };
        },
        methods: {},
    };
</script>

<style lang="scss" scoped>
    a {
        text-decoration: none;
    }
    .book-card {
        background-color: #fff;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        margin: 120px 15px 20px;
        min-height: 285px;
        padding: 90px 20px 15px;
        position: relative;
        width: 295px;
        .book-image {
            border-radius: 8px;
            height: 153px;
            left: 20px;
            position: absolute;
            top: -90px;
            width: 125px;
        }
        @media (max-width: 1430px) {
            margin: 120px 10px 20px;
            width: 280px;
        }
        .book-card__content {
            min-height: 150px;
        }
        .book-title {
            color: #4ac5e3;
            font-size: 18px;
            line-height: 22px;
        }
        .book-desc {
            color: #6d737d;
            font-size: 14px;
            line-height: 16px;
        }
        .book-isbn {
            color: #999;
            font-size: 14px;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .book-author {
            color: #a8adb5;
            font-size: 14px;
            line-height: 16px;
        }
        .book-footer {
            font-weight: bold;
            color: #454a55;
            display: flex;
            font-size: 14px;
            justify-content: space-between;
            line-height: 16px;
            margin-bottom: 5px;
        }
    }

    .book-list-view {
        align-items: flex-start;
        background: #fff;
        border-radius: 10px;
        cursor: pointer;
        display: flex;
        margin: 15px 45px 40px;
        min-height: 198px;
        padding: 20px 20px 15px 130px;
        position: relative;
        width: 100%;
        .book-image {
            border-radius: 8px;
            height: 120px;
            left: -20px;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100px;
        }
        .left {
            border-right: 1px dashed rgba(0, 0, 0, 0.2);
            flex-grow: 1;
            padding: 0 20px 0 0;
            width: 100%;
        }
        .right {
            display: flex;
            flex-direction: column;
            font-size: 14px;
            justify-content: center;
            line-height: 16px;
            padding: 0 30px;
            white-space: nowrap;
        }
        .book-title {
            color: #4ac5e3;
            font-size: 18px;
            line-height: 22px;
        }
        .book-isbn {
            color: #999;
            font-size: 14px;
            margin-bottom: 1rem;
            font-weight: bold;
        }
        .book-desc {
            color: #6d737d;
            font-size: 14px;
            line-height: 16px;
        }
        .book-author {
            color: #a8adb5;
            font-size: 14px;
            line-height: 16px;
        }
        .book-footer {
            font-weight: bold;
            color: #454a55;
        }
    }
</style>
