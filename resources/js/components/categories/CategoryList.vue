<template>
    <div class="section">
        <div class="row">
            <h1>Категории</h1>
            <div class="col-12">
                <add-button :url="addUrl" />
                <div class="cats-block mt-4 pt-4">
                    <ul v-if="categories.length">
                        <li-tag
                            v-for="cat in categories"
                            :key="`cat-${cat.id}`"
                            :category="cat"
                        ></li-tag>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import API from "../../helpers/api";
import AddButton from "../general/AddButton";
import LiTag from "./Embed/LiTag";

export default {
    name: "CategoryList",
    data: () => ({
        loading: false,
        categories: [],
    }),
    props: {
        addUrl: {
            type: String,
            required: true
        }
    },
    components: {
        AddButton,
        LiTag
    },
    created() {
        this.getCategories();
    },
    methods: {
        async getCategories() {
            await API.categoryEndpoint.getAll()
            .then(response => {
                this.categories = response.data.data.results;
            })
        }
    }
}
</script>

<style scoped lang="scss">
    .cats-block{
        border-top: 1px solid #DBDBDB;
    }
    ul{
        margin: 0;
        padding: 0;
        & li{
            list-style-type: none;
            font-size: 18px;
            line-height: 22px;
            padding: 15px 0 0 20px;
            border-bottom: 1px solid #DBDBDB;
            position: relative;
            &:after{
                content: url("/assets/img/icons/dropdown.png");
                position: absolute;
                top: 50%;
                right: 0;
            }
            &.rotate{
                &:after{
                    transform: rotate(180deg);
                }
            }
        }
    }
    .section{
        margin-bottom: 103px;
    }
</style>
