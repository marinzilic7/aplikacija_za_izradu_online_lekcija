<template>
    <div class="container d-flex justify-content-center">
        <div
            class="spinner-border text-secondary mt-5 spinner"
            role="status"
            v-if="loading"
        >
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="container mt-5" v-if="!loading">
        <div class="accordion accordion-flush shadow-lg" id="accordionFlushExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapseOne"
                        aria-expanded="false"
                        aria-controls="flush-collapseOne"
                    >
                        Sve lekcije
                    </button>
                </h2>
                <div
                    id="flush-collapseOne"
                    class="accordion-collapse collapse"
                    aria-labelledby="flush-headingOne"
                    data-bs-parent="#accordionFlushExample"
                >
                    <div class="accordion-body">
                        <ul>
                            <li class="mt-3  fw-bold" v-for="lekcija in lekcije">
                                <router-link class="text-decoration-none" :to="'/single/' + lekcija.id">{{
                                    lekcija.naslov
                                }}</router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
    data() {
        return {
            lekcije: [],
            loading: true,
            currentIndex: 0,
            tema: [],
            page: 1,

            soloLesson: [],
        };
    },

    computed: {
        ...mapState(["loginMessage"]),
        ...mapGetters(["loggedInUser"]),
        isLoggedIn() {
            return this.loggedInUser !== null;
        },
    },
    created() {
        if (this.loginMessage) {
            setTimeout(() => {
                this.$store.commit("setLoginMessage", "");
            }, 2000);
        }
        this.getLesson();
    },

    methods: {
        getLesson() {
            axios
                .get("/getLesson")
                .then((response) => {
                    this.lekcije = response.data.map((lesson) => ({
                        ...lesson,
                        created_at: new Date(
                            lesson.created_at
                        ).toLocaleDateString("hr-HR", {
                            day: "numeric",
                            month: "long",
                            year: "numeric",
                        }),
                    }));
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
    },
};
</script>

<style scoped>
.buttonOptions {
    position: relative;
    right: 5rem;
    width: 200%;
}

.spinner {
    position: relative;
    top: 20rem;
}

.custom-video {
    margin: auto !important;
    width: 100%;
    max-width: 800px;
    height: 350px;
}
</style>
