<template>
    <div v-if="successRegister"
      class="toast fade show position-absolute top-0 end-0 z-1 mt-5 me-3"
      style="margin-top: 70px !important"
      role="alert"
      aria-live="assertive"
      aria-atomic="true"
      data-bs-autohide="false"
    >
      <div class="toast-body bg-primary" >
        <strong class="text-light">{{ message }}</strong>
      </div>
    </div>
    <div clas="container ">
        <div class="d-flex justify-content-center mt-5">
            <form
                class="col-lg-4 border shadow-lg p-5 bg-light"
                @submit.prevent="regUser()"
                method="POST"
            >
                <input type="hidden" v-model="this.POST" />
                <input type="hidden" name="" v-model="this.csrfToken" />
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"
                        >Ime</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase ime"
                        v-model="form.ime"
                    />
                </div>
                <p v-if="errors.ime" class="text-danger">
                    {{ errors.ime[0] }}
                </p>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"
                        >Prezime</label
                    >
                    <input
                        type="text"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase prezime"
                        v-model="form.prezime"
                    />
                </div>
                <p v-if="errors.prezime" class="text-danger">
                    {{ errors.prezime[0] }}
                </p>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"
                        >Email adresa</label
                    >
                    <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase email"
                        v-model="form.email"
                    />
                </div>
                <p v-if="errors.email" class="text-danger">
                    {{ errors.email[0] }}
                </p>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label"
                        >Lozinka</label
                    >
                    <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Unesite vase lozinku"
                        v-model="form.password"
                    />
                </div>
                <p v-if="errors.password" class="text-danger">
                    {{ errors.password[0] }}
                </p>
                <button type="submit" class="btn btn-primary w-100 mt-2">
                    Registriraj se
                </button>
                <p class="mt-3 text-center">
                    Ako imate račun, onda kliknite na
                    <span
                        ><a
                            class="text-info text-decoration-none fw-bold"
                            href="/login"
                            >Prijava</a
                        ></span
                    >
                </p>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            form: {
                ime: "",
                prezime: "",
                email: "",
                password: "",
            },
            csrfToken: "",
            POST: "",
            errors: {},
            message: "",
        };
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
        regUser() {
            const Data = {
                ime: this.form.ime,
                prezime: this.form.prezime,
                email: this.form.email,
                password: this.form.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/registracija", Data)
                .then((response) => {
                    this.message = response.data.message;
                    this.successRegister = true;
                    this.form = {
                        ime: "",
                        prezime: "",
                        email: "",
                        password: "",
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

<style lang="scss" scoped></style>
