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
    <div class="container" v-if="!loading">
        <div class="mt-5 border border-secondary shadow-lg">
            <div
                class="accordion accordion-flush bg-secondary"
                id="accordionFlushExample"
            >
                <div
                    class="spinner-border text-secondary"
                    role="status"
                    v-if="loading"
                >
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div
                    class="accordion-item"
                    :class="'accordion-' + lekcija.id"
                    v-for="lekcija in lekcije"
                >
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="'#flush-collapseOne' + lekcija.id"
                            aria-expanded="false"
                            aria-controls="flush-collapseOne"
                        >
                            <p class="fw-bold">
                                <span class="text-primary fw-bold"
                                    >Lekcija</span
                                >
                                : {{ lekcija.naslov }}
                            </p>
                        </button>
                    </h2>
                    <div
                        :id="'flush-collapseOne' + lekcija.id"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-headingOne"
                        data-bs-parent="#accordionFlushExample"
                    >
                        <div class="accordion-body">
                            <div class="d-flex justify-content-between">
                                <p>
                                    <span class="fw-bold">Korisnik:</span>
                                    {{ lekcija.user.ime }}
                                </p>
                                <p>
                                    <span class="fw-bold">Kategorija:</span>
                                    {{ lekcija.category.ime }}
                                </p>
                            </div>
                            <div>
                                <p>
                                    <span class="fw-bold">Opis:</span>
                                    {{ lekcija.opis }}
                                </p>
                            </div>
                            <hr />

                            <div>
                                <h3>
                                    Tema : {{ lekcija.detail[indexx].tema }}
                                </h3>
                            </div>
                            <div class="mt-3">
                                <h4>Sadrzaj :</h4>
                                <p>{{ lekcija.detail[indexx].lekcija }}</p>
                            </div>
                            <div class="mt-3">
                                <video
                                    class="card-img-top custom-video"
                                    controls
                                    v-if="lekcija.detail[indexx].video"
                                >
                                    <source
                                        :src="
                                            '/videos/' +
                                            lekcija.detail[indexx].video
                                        "
                                    />
                                    Your browser does not support the video tag.
                                </video>
                                <div  v-if="lekcija.detail[indexx].image">

                                    <img :src="getImageUrl(lekcija.detail[indexx].image)" alt="" />
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button
                                    class="btn btn-danger btn-sm"
                                    @click="prevLesson(indexx)"
                                >
                                    Vrati
                                </button>
                                <button
                                    class="btn btn-sm btn-success"
                                    @click="nextLesson(indexx)"
                                >
                                    Sljedece
                                </button>
                            </div>
                        </div>
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
            indexx: 0,
            tema: [],
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
                    this.loading = false; // Postavite loading na false nakon što se podaci učitaju
                });
        },

        nextLesson(indexx) {
            this.lekcije.forEach((element, index) => {
                console.log("DETAIL ->", element.detail);
                if (this.indexx < element.detail.length - 1) {
                    this.indexx++;
                }
            });
        },

        prevLesson(indexx) {
            this.lekcije.forEach((element, index) => {
                if (this.indexx > 0) {
                    this.indexx--;
                }
            });
        },

        getImageUrl(imageName) {
            return `/images/${imageName}`;
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
  margin:auto !important;
  width: 100%; /* Postavite širinu videa na 100% roditeljskog elementa */
  max-width: 800px; /* Ograničite maksimalnu širinu videa, prilagodite je vašim potrebama */
  height: auto; /* Automatski prilagodite visinu kako biste očuvali proporcije */
}
</style>
