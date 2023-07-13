<template>
<div>
    <div class="row mb-3">
        <input type="hidden" name="type" :value="type">
        <label class="col-sm-2 col-form-label">К чему скидка</label>
        <div class="col-sm-10">
            <select class="form-select" aria-label="Тип" v-model="type" @change="setType">
                <option v-for="(t,i) in types" :key="i" :value="t.key">{{ t.value }}</option>
            </select>
        </div>
    </div>
    <template v-if="currentTypeComponent">
        <component :is="{...currentTypeComponent}" v-bind="componentProperties"></component>
    </template>
</div>
</template>

<script>
import CourseSaleSearch from "./CourseSaleSearch";
import SchoolSaleSearch from "./SchoolSaleSearch";
export default {
    name: "SaleType",
    props: {
        saleType: {
            type: String,
            required: false,
            default: null
        },
        schoolId: {
            type: String,
            required: false,
            default: null
        },
        courseId: {
            type: String,
            required: false,
            default: null
        },
    },
    created() {
        if (this.saleType !== null) {
            this.type = this.saleType;
            this.setType();
        }

        if (this.schoolId) {
            this.componentProperties = {
                schoolId: this.schoolId
            };
        }
    },
    components: {
        CourseSaleSearch,
        SchoolSaleSearch
    },
    data: () => ({
        type: null,
        currentTypeComponent: null,
        componentProperties: null
    }),
    computed: {
        types() {
            return [
                {key: 'school', value: 'К школе'},
                {key: 'course', value: 'К курсу'},
            ]
        }
    },
    methods: {
        setType() {
            if (this.type === 'school') {
                this.currentTypeComponent = SchoolSaleSearch;
            }

            if (this.type === 'course') {
                this.currentTypeComponent = CourseSaleSearch;
            }
        },
    }
}
</script>

<style scoped>

</style>
