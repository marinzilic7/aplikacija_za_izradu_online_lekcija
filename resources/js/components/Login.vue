<template>
    <div clas="container ">
        <div class="d-flex justify-content-center mt-5">
            <form
                class="col-lg-4 border shadow-lg p-5 bg-light"
                @submit.prevent="logUser()"
                method="POST"
            >
                <div class="mb-3">
                    <input type="hidden" v-model="this.POST" />
                    <input type="hidden" name="" v-model="this.csrfToken" />
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
                <button type="submit" class="btn btn-primary w-100">
                    Prijava
                </button>
                <p class="mt-3 text-center">
                    Ako nemate račun, onda kliknite na
                    <span
                        ><a
                            class="text-info text-decoration-none fw-bold"
                            href="/register"
                            >Registracija</a
                        ></span
                    >
                </p>

                <p v-if="falseReg" class="alert alert-danger">Pogresan email ili lozinka</p>
            </form>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { mapActions } from "vuex";
export default {
    data() {
        return {
            form: {
                email: "",
                password: "",
            },
            errors: {},
            csrfToken: "",
            POST: "",
            logMessage: "",
            falseReg: false,
            successRegg: false,
        };
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
        logUser() {
            const Data = {
                email: this.form.email,
                password: this.form.password,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/prijava", Data)
                .then((response) => {
                    this.logMessage = response.data.poruka;

                    this.successRegg = true;
                    if (this.logMessage == "Uspješna prijava") {
                        this.$store.dispatch(
                            "setLoginMessage",
                            this.logMessage
                        );
                        this.$store.commit(
                            "setLoggedInUser",
                            response.data.user
                        );
                        this.successRegg = true;
                        this.falseReg = false;
                        this.$router.push("/");
                    } else {
                        this.falseReg = true;
                        this.successRegg = false;
                    }
                })
                .catch((error) => {
                    console.log("Error:", error);
                    if (error.response && error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    } else {
                        console.log(error);
                    }
                });
        },
    },
    ...mapActions(["setLoginMessage"]),
};
</script>

<style lang="scss" scoped></style>
