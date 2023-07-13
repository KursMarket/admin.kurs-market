<template>
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="action-panel">
                    <div class="list-actions">
                        <a href="" @click.prevent="removePositions"><img src="/assets/img/icons/bi_trash3.png" alt="">Удалить</a>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <a href="/tags/create" class="card-title btn"><img src="/assets/img/icons/bi_plus-circle.png" alt="" class="me-2">Добавить</a>

                        <!-- Default Table -->
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">
                                    <input
                                        type="checkbox"
                                        class="form-check"
                                        @change="selectAllCheckboxes($event, tags)"
                                        v-model="allSelected"
                                        :checked="ids.length === tags.length"
                                    >
                                </th>
                                <th scope="col">ID</th>
                                <th scope="col">Название</th>
                                <th scope="col">Алиас</th>
                                <th scope="col">Порядок сортировки</th>
                                <th scope="col">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-if="tags.length">
                                <tr v-for="(t,k) in tags" :key="k">
                                    <th scope="row">
                                        <input
                                            type="checkbox"
                                            class="form-check"
                                            v-model="ids"
                                            :value="t.id"
                                            :checked="ids.includes(t.id)"
                                            @change="checkCurrentSchool(t.id, $event)"
                                            >
                                    </th>
                                    <th scope="row">{{ t.id }}</th>
                                    <td>{{ t.title }}</td>
                                    <td>{{ t.alias }}</td>
                                    <td>{{ t.sort_order }}</td>
                                    <td>
                                        <a
                                            :href="`/tags/${t.id}/edit`"
                                            class="btn edit" >
                                            <img src="/assets/img/icons/bi_pencil.png" alt="">
                                            Редактировать
                                        </a>
                                    </td>
                                </tr>

                            </template>
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import API from "../../helpers/api";
import vfCheckboxes from "../../mixins/checkboxes";

export default {
    name: "TagList",
    mixins: [vfCheckboxes],
    data: () => ({
        tags: [],
    }),
    created() {
        this.getAll();
    },
    methods: {
        async getAll() {
            await API.tagEndpoint.getAll()
                .then(response => {
                    this.tags = response.data.data.results;
                })
        },
        async removePositions() {
            if (this.ids.length && confirm('Вы уверены? Теги удалятся навсегда!')) {
                await API.tagEndpoint.remove(this.ids)
                    .then(response => {
                        if (response.data.status) {
                            this.getAll();
                        }
                    })
            }
        }
    }
}
</script>

<style scoped>

</style>
