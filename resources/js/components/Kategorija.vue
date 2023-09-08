<template>
    <div class="container d-flex justify-content-center">
        <div class="mt-5">
            <button
                type="button"
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
                data-bs-whatever="@getbootstrap"
            >
                Dodaj kategoriju
            </button>
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
                                <input
                                    type="hidden"
                                    name=""
                                    v-model="this.csrfToken"
                                />
                                <div class="mb-3">
                                    <label
                                        for="recipient-name"
                                        class="col-form-label"
                                        >Ime kategorije:</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="recipient-name"
                                        v-model="category.ime"
                                    />
                                </div>
                                <p v-if="errors.ime" class="text-danger">
                                    {{ errors.ime[0] }}
                                </p>
                                <button
                                    type="submit"
                                    class="btn btn-success w-100"
                                >
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
        </div>
    </div>


        <!-- LISTA KATEGORIJA -->

    <div class="container mt-5">
        <div>
            <table class="table table-secondary shadow-lg">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Ime</th>
                    <th scope="col">Datum</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="category in categories" :key="category.id">
                    <th scope="row">{{ category.id }}</th>
                    <td>{{ category.ime}}</td>
                    <td>{{ category.created_at }}</td>
                </tr>
            </tbody>
        </table>
        </div>

    </div>
</template>

<script>
import axios from "axios";

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
            categories: [],
        };
    },
    mounted() {
        this.fetchCsrfToken();
        this.getCategories();
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
                    this.getCategories();
                })
                .catch((error) => {
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
        getCategories() {
            axios
                .get("/getCategories")
                .then((response) => {
                    this.categories = response.data.map((category) => ({
                        ...category,
                        created_at: new Date(
                            category.created_at
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

<style lang="scss" scoped></style>
