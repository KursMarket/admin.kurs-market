import './bootstrap';
import {createApp} from 'vue';

import store from './store/index';

import Paginate from "vuejs-paginate-next";
import Notifications from '@kyvg/vue3-notification';

import SchoolList from "./components/schools/SchoolList";
import EditSchool from "./components/schools/EditSchool";
import CategoryList from "./components/categories/CategoryList";
import EditCategory from "./components/categories/EditCategory";
import CatalogTypesList from "./components/categories/CatalogTypesList";
import CreateType from "./components/categories/CreateType";
import EditType from "./components/categories/EditType";
import TagSave from "./components/tags/TagSave";
import TagList from "./components/tags/TagList";
import DurationList from "./components/durations/DurationList";
import DurationSave from "./components/durations/DurationSave";
import CoursesList from "./components/courses/CoursesList";
import CourseEdit from "./components/courses/CourseEdit";
import Banner from "./components/settings/Banner";
import Advantages from "./components/settings/Advantages";
import QuizModule from "./components/settings/QuizModule";
import PromoModule from "./components/settings/PromoModule";
import Collaboration from "./components/settings/Collaboration";
import ReviewsList from "./components/reviews/ReviewsList.vue";
import ReviewEdit from "./components/reviews/ReviewEdit.vue";
import SaleType from "./components/sales/SaleType";

const app = createApp({});

app.component('paginate', Paginate);
app.component('school-list', SchoolList);
app.component('edit-school', EditSchool);
app.component('category-list', CategoryList);
app.component('category-edit', EditCategory);
app.component('catalog-types-list', CatalogTypesList);
app.component('edit-type', EditType);
app.component('create-type', CreateType);
app.component('tag-list', TagList);
app.component('tag-save', TagSave);
app.component('duration-list', DurationList);
app.component('duration-save', DurationSave);
app.component('courses-list', CoursesList);
app.component('courses-edit', CourseEdit);
app.component('banner', Banner);
app.component('advantages', Advantages);
app.component('quiz-module', QuizModule);
app.component('promo-module', PromoModule);
app.component('collaboration-module', Collaboration);
app.component('reviews-list', ReviewsList);
app.component('review-edit', ReviewEdit);
app.component('sale-type', SaleType);
app.use(store);
app.use(Notifications);
app.mount('#main');
