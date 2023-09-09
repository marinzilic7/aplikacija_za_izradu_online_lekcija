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
                Dodaj lekciju
            </button>
            <button
                class="btn btn-primary ms-3"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasRight"
                aria-controls="offcanvasRight"
            >
                Opcije
            </button>

            <div
                class="offcanvas offcanvas-end"
                tabindex="-1"
                id="offcanvasRight"
                aria-labelledby="offcanvasRightLabel"
            >
                <div class="offcanvas-header">
                    <h5 id="offcanvasRightLabel">Dodaj u lekciju..</h5>
                    <button
                        type="button"
                        class="btn-close text-reset"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="offcanvas-body">
                    <form>
                        <div class="mb-3">
                            <select
                                class="form-select"
                                aria-label="Default select example"
                                v-model="details.lesson_id"
                                required
                            >
                                <option v-for="lesson in lessons">
                                    {{ lesson.naslov }}
                                </option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label"
                                >Tema lekcije</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="exampleInputEmail1"
                                aria-describedby="emailHelp"
                                v-model="details.tema"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label
                                for="exampleInputPassword1"
                                class="form-label"
                                >Sadrzaj lekcije</label
                            >
                            <textarea
                                type="text"
                                class="form-control"
                                id="exampleInputPassword1"
                                v-model="details.lekcija"
                                required
                            />
                        </div>
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label"
                                >Dodaj sliku
                                <span class="text-warning fw-bold"
                                    >*</span
                                ></label
                            >
                            <input
                                class="form-control form-control-sm"
                                id="formFileSm"
                                type="file"

                            />
                        </div>
                        <div class="mb-3">
                            <label for="formFileSm" class="form-label"
                                >Dodaj video
                                <span class="text-warning fw-bold"
                                    >*</span
                                ></label
                            >
                            <input
                                class="form-control form-control-sm"
                                id="formFileSm"
                                type="file"
                            />
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Submit
                        </button>
                        <p class="fst-italic"><span class="text-warning fw-bold">*</span> - nije obavezno</p>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
                        Nova lekcija
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="dodajLekciju()" method="POST">
                        <input type="hidden" v-model="this.POST" />
                        <input type="hidden" name="" v-model="this.csrfToken" />
                        <div class="mb-3">
                            <label for="recipient-name" class="col-form-label"
                                >Naslov:</label
                            >
                            <input
                                type="text"
                                class="form-control"
                                id="recipient-name"
                                v-model="lekcija.naslov"
                            />
                            <p v-if="errors.naslov" class="text-danger">
                                {{ errors.naslov[0] }}
                            </p>
                        </div>
                        <div class="mb-3">
                            <label for="message-text" class="col-form-label"
                                >Opis:</label
                            >
                            <textarea
                                class="form-control"
                                id="message-text"
                                v-model="lekcija.opis"
                            ></textarea>
                        </div>
                        <p v-if="errors.opis" class="text-danger">
                            {{ errors.opis[0] }}
                        </p>
                        <div class="mb-3">
                            <label for="Category">Kategorija</label>
                            <select
                                class="form-select"
                                aria-label="Default select example"
                                v-model="lekcija.category_id"
                                required
                            >
                                <option
                                    v-for="category in categories"
                                    :value="category.id"
                                    :key="category.id"
                                >
                                    {{ category.ime }}
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100">
                            Dodaj lekciju
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

    <!-- LISTA LEKCIJA -->

    <div class="container">
        <div class="container mt-5">
            <div>
                <table class="table table-secondary shadow-lg">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Korisnik</th>
                            <th scope="col">Kategorija</th>
                            <th scope="col">Naslov</th>
                            <th scope="col">Opis</th>
                            <th scope="col">Datum</th>
                            <th scope="col">Uredi</th>
                            <th scope="col">Izbrisi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="lesson in lessons" :key="lesson.id">
                            <th scope="row">{{ lesson.id }}</th>
                            <td>{{ lesson.user.ime }}</td>
                            <td>{{ lesson.category.ime }}</td>
                            <td>{{ lesson.naslov }}</td>
                            <td>{{ lesson.opis }}</td>
                            <td>{{ lesson.created_at }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal"
                                    :data-bs-target="'#updateModal' + lesson.id"
                                    data-bs-whatever="@getbootstrap"
                                    @click="openUpdateLesson(lesson)"
                                >
                                    Uredi
                                </button>
                                <div
                                    class="modal fade"
                                    :id="'updateModal' + lesson.id"
                                    tabindex="-1"
                                    :aria-labelledby="
                                        'exampleModalLabel' + lesson.id
                                    "
                                    aria-hidden="true"
                                >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5
                                                    class="modal-title"
                                                    :id="
                                                        'modalUpdate' +
                                                        lesson.id
                                                    "
                                                >
                                                    Uredi lekciju
                                                </h5>
                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal"
                                                    aria-label="Close"
                                                ></button>
                                            </div>
                                            <div class="modal-body">
                                                <form
                                                    @submit.prevent="
                                                        urediLekciju(lesson.id)
                                                    "
                                                    method="POST"
                                                >
                                                    <input
                                                        type="hidden"
                                                        v-model="this.POST"
                                                    />
                                                    <input
                                                        type="hidden"
                                                        name=""
                                                        v-model="this.csrfToken"
                                                    />
                                                    <div class="mb-3">
                                                        <label
                                                            for="recipient-name"
                                                            class="col-form-label"
                                                            >Naslov:</label
                                                        >
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            id="recipient-name"
                                                            v-model="
                                                                lekcija.naslov
                                                            "
                                                        />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label
                                                            for="message-text"
                                                            class="col-form-label"
                                                            >Opis:</label
                                                        >
                                                        <textarea
                                                            class="form-control"
                                                            id="message-text"
                                                            v-model="
                                                                lekcija.opis
                                                            "
                                                        ></textarea>
                                                    </div>
                                                    <button
                                                        type="submit"
                                                        class="btn btn-primary w-100"
                                                    >
                                                        Uredi lekciju
                                                    </button>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button
                                                    type="button w-100"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal"
                                                >
                                                    Zatvori
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-outline-danger"
                                    @click="deleteLesson(lesson.id)"
                                >
                                    Izbrisi
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            lekcija: {
                category_id: "",
                naslov: "",
                opis: "",
            },
            categories: [],
            csrfToken: "",
            POST: "",
            errors: {},
            message: "",
            lessons: [],
            currentLessonId: null,

            details: {
                lesson_id: "",
                tema: "",
                lekcija: "",
                image: "",
                video: "",
            },
        };
    },
    created() {
        this.getCategories();
        this.getLesson();
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
        dodajLekciju() {
            const Data = {
                category_id: this.lekcija.category_id,
                naslov: this.lekcija.naslov,
                opis: this.lekcija.opis,
            };
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            axios
                .post("/dodajLekciju", Data)
                .then((response) => {
                    this.message = response.data.message;
                    this.getLesson();
                    $("#exampleModal").modal("hide");
                    this.lekcija = {
                        category_id: "",
                        naslov: "",
                        opis: "",
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

        getLesson() {
            axios
                .get("/getLesson")
                .then((response) => {
                    this.lessons = response.data.map((lesson) => ({
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

        deleteLesson(id) {
            axios
                .post(`/deleteLesson/${id}`)
                .then((response) => {
                    this.message = response.data.message;
                    this.getLesson();
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        openUpdateLesson(lesson) {
            this.currentLessonId = lesson.id;
            this.lekcija.naslov = lesson.naslov;
            this.lekcija.opis = lesson.opis;

            $("#updateModal" + lesson.id).modal("show");
        },

        urediLekciju(id) {
            axios.defaults.headers.common["X-CSRF-TOKEN"] = this.csrfToken;
            console.log(id);

            axios
                .post(`/urediLekciju/${id}`, {
                    naslov: this.lekcija.naslov,
                    opis: this.lekcija.opis,
                })
                .then((response) => {
                    this.message = response.data.message;

                    const updatedLesson = response.data.lesson;
                    console.log(updatedLesson);
                    const index = this.lessons.findIndex(
                        (lesson) => lesson.id === this.currentLessonId
                    );
                    if (index !== -1) {
                        this.lessons[index].naslov = updatedLesson.naslov;
                        this.lessons[index].opis = updatedLesson.opis;
                    }

                    $("#updateModal" + this.currentLessonId).modal("hide");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
