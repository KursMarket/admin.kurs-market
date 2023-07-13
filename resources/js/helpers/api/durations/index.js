import {createAxiosJsonRequest, DURATIONS} from "../base";

export default {
    save(data) {
        return createAxiosJsonRequest(`${DURATIONS}`, 'post', data);
    },
    getAll() {
        return createAxiosJsonRequest(`${DURATIONS}`);
    },
    getById(id) {
        return createAxiosJsonRequest(`${DURATIONS}/${id}`);
    },
    remove(data) {
        return createAxiosJsonRequest(`${DURATIONS}/delete`, 'post', {ids: data})
    }
}
