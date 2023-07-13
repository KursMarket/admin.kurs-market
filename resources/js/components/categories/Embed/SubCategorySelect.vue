<template>
    <label for="related_sub_category" class="col-sm-2 col-form-label mt-4">
        <button
            class="btn"
            @click.prevent="removeRelatedSubcategory">
            <img src="/assets/img/icons/bi_minus-circle.png" alt="Remove">
        </button>
    </label>
    <div class="col-sm-10">
        <select name="related_category" id="related_sub_category" class="form-select mt-4" @change="setRelated">
            <option value="">-- Выбрать --</option>
            <option
                :value="cat.id"
                v-for="cat in relatedSubCategories"
                :key="`option-related-sub-category-${cat.id}`"
            >{{cat.title}}</option>
        </select>
    </div>
</template>

<script>
import API from "../../../helpers/api";
import {mapGetters} from 'vuex';
export default {
    name: "SubCategorySelect",
    setup() {
    },
    emits: ['setRelatedChildren', 'removeRelatedSubcategory'],
    props: {
        parentCategoryId: {
            type: [String, Number],
            required: true
        },
        index: {
            type: Number,
            required: true
        }
    },
    data: () => ({
        relatedSubCategories: []
    }),
    computed: {
        ...mapGetters([
            'getStateCategories'
        ])
    },
    methods: {
        async getChildCategories(id) {
            await API.categoryEndpoint.getChildCategoriesByParentId(id)
            .then(response => {
                this.relatedSubCategories = response.data.data.results
            })
        },
        setRelated(e) {
            this
                .$store
                .dispatch('saveCategory', {index: this.index, id: e.target.value})
            ;
        },
        removeRelatedSubcategory() {
            this
                .$store
                .dispatch('removeCategory', {index: this.index})
            ;
        }
    },
    mounted() {
        this.getChildCategories(this.parentCategoryId)
    }
}
</script>

<style scoped>

</style>
