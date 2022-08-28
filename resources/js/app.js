import './bootstrap';
import {createApp} from "vue";
import SiteTemplatePreviewComponent from "./components/site-template-preview-component.vue";

const app = createApp({});

app.component('site-template-preview', SiteTemplatePreviewComponent)

app.mount('#app');
