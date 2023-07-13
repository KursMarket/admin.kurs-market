import {createAxiosJsonRequest, TAGS} from "../base";

export default {
    save(data) {
        return createAxiosJsonRequest(`${TAGS}`, 'post', data);
    },
    getAll() {
        return createAxiosJsonRequest(`${TAGS}`);
    },
    getById(id) {
        return createAxiosJsonRequest(`${TAGS}/${id}`);
    },
    remove(data) {
        return createAxiosJsonRequest(`${TAGS}/delete`, 'post', {ids: data})
    }
}
