<template>
    <div class="container">
        <div
            class="mt-5 border border-secondary  shadow-lg"

        >
            <div class="accordion accordion-flush bg-secondary " id="accordionFlushExample">
                <div class="accordion-item " :class="'accordion-' + lekcija.id" v-for="lekcija in lekcije">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button
                            class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            :data-bs-target="'#flush-collapseOne' + lekcija.id"
                            aria-expanded="false"
                            aria-controls="flush-collapseOne"
                        >
                           <span class="text-primary fw-bold">Lekcija</span> : {{lekcija.naslov}}
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
                                <p><span class="fw-bold">Korisnik:</span> {{ lekcija.user.ime }}</p>
                                <p><span class="fw-bold">Kategorija:</span> {{ lekcija.category.ime }}</p>
                            </div>
                            <div>
                                <p><span class="fw-bold">Opis:</span> {{ lekcija.opis  }}</p>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <!-- Dodajte ostale informacije o lekciji koje želite prikazati -->
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
</style>
