<template>
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <add-button :url="addUrl"/>
                <div class="action-panel">
                    <div class="list-actions">
                        <a href="" @click.prevent="removeMultiple"><img src="/assets/img/icons/bi_trash3.png" alt="">Удалить</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <input
                                        type="checkbox"
                                        @change="selectAllCheckboxes"
                                        v-model="allSelected"
                                        :checked="this.types.length === this.catalogTypeIds.length"
                                        class="form-check">
                                </th>
                                <th scope="col">id</th>
                                <th scope="col">Название</th>
                                <th scope="col">ЧПУ</th>
                                <th scope="col">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="types.length" v-for="(type, key) in types" :key="key">
                                <td>
                                    <input
                                        type="checkbox"
                                        class="form-check"
                                        :value="type.id"
                                        v-model="catalogTypeIds"
                                        :checked="catalogTypeIds.includes(type.id)"
                                        @change="checkCurrentType(type.id, $event)"
                                    >
                                </td>
                                <td>{{ type.id }}</td>
                                <td>{{ type.title }}</td>
                                <td>{{ type.url }}</td>
                                <td class="actions">
                                    <a href="" @click.prevent="remove(type.id)"><img src="/assets/img/icons/bi_trash3.png" alt="">Удалить</a>
                                    <a :href="`/types/${type.id}/edit`" class="btn edit"><img src="/assets/img/icons/bi_pencil.png" alt="">Редактировать</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import AddButton from "../general/AddButton";
import API from "../../helpers/api";

export default {
    name: "CatalogTypesList",
    components: {
        AddButton
    },
    props: {
        addUrl: {
            type: String,
            required: true
        }
    },
    data: () => ({
        types: [],
        allSelected: false,
        catalogTypeIds: []
    }),
    created() {
        this.getCatalogTypes();
    },
    methods: {
        async getCatalogTypes() {
            await API.categoryEndpoint.getAllTypes()
            .then(response => {
                this.types = response.data.data.results;
            })
        },
        async remove(id) {
            await API.categoryEndpoint.removeCatalogType(id)
            .then(response => {
                if (response.data.status) {
                    this.getCatalogTypes();
                }
            })
        },
        async removeMultiple() {
            if (confirm('Вы хотите удалить из системы школы, которые не смогут быть восстановлены. Вы уверены?')) {
                await API.categoryEndpoint.removeMultiple(this.catalogTypeIds)
                .then(response => {
                    if (response.data.status) {
                        this.catalogTypeIds = [];
                        this.getCatalogTypes();
                    }
                })
            }
        },
        checkCurrentType(id, e) {
            if (!e.target.checked) {
                this.catalogTypeIds = this.catalogTypeIds.filter(t => t !== id);
            } else {
                if (!this.catalogTypeIds.find(t => t === id)) {
                    this.catalogTypeIds.push(id);
                }
            }
        },
        selectAllCheckboxes(e) {
            this.catalogTypeIds = [];
            if (e.target.checked) {
                if (this.types.length) {
                    for (const i in this.types) {
                        this.catalogTypeIds.push(this.types[i].id)
                    }
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
