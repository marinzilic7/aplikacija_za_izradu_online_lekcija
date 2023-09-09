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
                            <span class="text-primary fw-bold">Lekcija</span> :
                            {{ lekcija.naslov }}
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
                                <h3>Tema : {{ lekcija.detail[index].tema }}</h3>
                            </div>
                            <div class="mt-3">
                                <h4>Sadrzaj :</h4>
                                <p>{{ lekcija.detail[index].lekcija }}</p>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn btn-danger btn-sm">
                                    Vrati
                                </button>
                                <button
                                    class="btn btn-sm btn-success"
                                    @click="nextLesson()"
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
            index: 0,
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

        nextLesson() {

            console.log("duzina",this.lekcije.detail.length)
            if (this.index < this.lekcije.detail.length - 1) {
                this.index++;
            }
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
</style>
