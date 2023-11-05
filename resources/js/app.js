import "./bootstrap";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

import { createApp } from "vue";
import App from "./components/App.vue";

const app = createApp({
    components: {
        App,
    },
});

app.mount("#app");
