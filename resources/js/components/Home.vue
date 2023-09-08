<template>
    <div
        v-if="loginMessage"
        class="toast fade show position-absolute top-0 end-0 z-1 mt-5 me-3"
        style="margin-top: 70px !important"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-autohide="false"
    >
        <div class="toast-body bg-primary">
            <strong class="text-light"> {{ loginMessage }}</strong>
        </div>
    </div>
    <div class="container d-flex justify-content-center">
        <div class="mt-5">

        </div>
    </div>

    <!-- MODAL ZA DODAVANJE KATEGORIJE -->

    <div
        class="modal fade"
        id="exampleModal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Nova kategorija
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="addCategory()" method="POST">
                        <input type="hidden" v-model="this.POST" />
                        <input type="hidden" name="" v-model="this.csrfToken" />
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label"
                                >Ime kategorije:</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="recipient-name"
                                v-model="category.ime"
                            />
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            Dodaj kategoriju
                        </button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-danger w-100"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>
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
            category: {
                ime: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            message: "",
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
    },
    mounted() {
        this.fetchCsrfToken();
    },
    methods: {
        fetchCsrfToken() {
            axios
                .get("/sanctum/csrf-cookie")
                .then((response) => {
                    this.csrfToken = response.data.csrf_token;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        addCategory() {
            const Data = {
                ime: this.category.ime,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/addCategory", Data)
                .then((response) => {
                    this.message = response.data.message;
                    $("#exampleModal").modal("hide");
                    this.category = {
                        ime: "",
                    };
                    this.errors = {};
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
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
