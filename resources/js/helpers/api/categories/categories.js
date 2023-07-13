import {CATEGORIES, TYPES, createAxiosJsonRequest} from "../base";

export default {
    saveCategory(data) {
        return createAxiosJsonRequest(`${CATEGORIES}`, 'post', data);
    },
    makeUrlFromTitle(title, id) {
        return createAxiosJsonRequest(`${CATEGORIES}/url`, 'patch', {title, id});
    },
    getAll() {
        return createAxiosJsonRequest(`${CATEGORIES}`);
    },
    getAllCategoriesForSelect() {
        return createAxiosJsonRequest(`${CATEGORIES}/get`);
    },
    rmRelated(categoryId, relatedId) {
        return createAxiosJsonRequest(`${CATEGORIES}/remove-related/${categoryId}/${relatedId}`, 'delete')
    },
    getCategoryById(id) {
        return createAxiosJsonRequest(`${CATEGORIES}/get-one/${id}`);
    },
    saveCatalogType(data) {
        return createAxiosJsonRequest(`${TYPES}`, 'post', data);
    },
    getAllTypes() {
        return createAxiosJsonRequest(`${TYPES}`);
    },
    getById(id) {
        return createAxiosJsonRequest(`${TYPES}/${id}`);
    },
    removeCatalogType(id) {
        return createAxiosJsonRequest(`${TYPES}/${id}`, 'delete');
    },
    removeMultiple(types) {
        return createAxiosJsonRequest(`${TYPES}/remove`, 'post', {types})
    },
    removeCategory(id) {
        return createAxiosJsonRequest(`${CATEGORIES}/${id}`, 'delete')
    },
    getChildCategoriesByParentId(id) {
        return createAxiosJsonRequest(`${CATEGORIES}/children/${id}`);
    }
}
