<template>
    <li :class="openCategory ? 'rotate': ''">
        <a
            href=""
            @click.prevent="openCategory = !openCategory"
        >
            {{ category.title }}
            ({{ category.total }})
        </a>
        <img src="/assets/img/icons/bi_pencil.png" @click="moveToEdit(category.id)" alt="Edit">
        <template v-if="openCategory">
            <div class="inside">
                <a :href="`/categories/create/${category.id}`" class="add-subcategory">+ Добавть подкатегорию</a>
                    <ul v-if="category.children">
                        <li-tag
                            v-for="cat in category.children"
                            :key="`cat-${cat.id}`"
                            :category="cat"
                        ></li-tag>
                    </ul>
            </div>
        </template>
    </li>
</template>

<script>
export default {
    name: "LiTag",
    props: {
        category: {
            type: [Object, Array],
            required: false,
            default: null
        }
    },
    data: () => ({
        openCategory: false,
        showPopup: false
    }),
    methods: {
        moveToEdit(id) {
            window.location.href = `/categories/${id}/edit`
        }
    }
}
</script>

<style scoped lang="scss">
    li{
        display: flex;
        flex-direction: column;
        position: relative;
        padding-left: 15px;
        & img{
            width: 15px;
            position: absolute;
            left: 0;
            cursor: pointer;
        }
        & > a{
            color: #000;
            font-weight: 500;
        }

        & ul {
            padding: 0;

            & li {
                padding: 15px 0 0 20px;
            }
        }
    }
    .add-subcategory{
        color: #D75D5D;
        font-size: 19px;
        font-weight: 400;
    }
    .inside{
        padding-left: 1rem;
        padding-top: 1rem;
    }
</style>
