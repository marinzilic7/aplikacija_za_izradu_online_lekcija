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
        <div class="border shadow-lg p-3">
            <div class="d-flex justify-content-between">
                <p><span class="fw-bold">Korisnik:</span> {{ soloLesson.user.ime }}</p>
                <p>
                    <span class="fw-bold">{{ page }}</span> od
                    {{ soloLesson.detail ? soloLesson.detail.length : 0 }}
                </p>
            </div>
            <div class="d-flex justify-content-between">
                <p><span class="fw-bold">Opis:</span> {{ soloLesson.opis }}</p>
                <p>
                    <span class="fw-bold">Kategorija:</span>
                    {{ soloLesson.category.ime }}
                </p>
            </div>
            <hr />
            <div v-if="soloLesson.detail && soloLesson.detail.length > 0">
                <p>
                    <span class="fw-bold">Tema: </span>
                    {{ soloLesson.detail[index].tema }}
                </p>
                <p>
                    <span class="fw-bold">Sadrzaj: </span>
                    {{ soloLesson.detail[index].lekcija }}
                </p>
            </div>
            <div class="mt-3 d-flex justiy-content-center">
                <video
                    class="card-img-top custom-video"
                    controls
                    v-if="
                        soloLesson.detail[index].video &&
                        soloLesson.detail[index].video !== 'null'
                    "
                >
                    <source
                        :src="'/videos/' + soloLesson.detail[index].video"
                    />
                    Your browser does not support the video tag.
                </video>
            </div>
            <div
                class="d-flex justify-content-center"
                v-if="soloLesson.detail[index].image"
            >
                <img
                    :src="getImageUrl(soloLesson.detail[index].image)"
                    alt=""
                    class="img-fluid m-auto"
                    style="max-width: 300px; height: auto"
                />
            </div>
            <div class="d-flex justify-content-between">
                <button
                    :disabled="index == 0"
                    class="btn btn-sm btn-danger"
                    @click="prevLesson()"
                >
                    Previous
                </button>
                <button
                    :disabled="index == soloLesson.detail.length - 1"
                    class="btn btn-sm btn-primary"
                    @click="nextLesson()"
                >
                    Next
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            soloLesson: {
                user: {
                    ime: "",
                },
                category: {
                    ime: "",
                },
                detail: {
                    opis: "",
                    tema: "",
                    lekcija: "",
                    video: "",
                    image: "",
                },
            },
            page: 1,
            index: 0,
            loading: true,
        };
    },
    created() {
        this.lekcijaId = this.$route.params.id;
        this.dohvatiLekciju(); // Pozovite funkciju za dohvaćanje podataka o lekciji
    },
    methods: {
        dohvatiLekciju() {
            axios
                .get(`/dohvatiLekciju/${this.lekcijaId}`)
                .then((response) => {
                    this.soloLesson = response.data;
                    console.log(this.soloLesson);
                })
                .catch((error) => {
                    console.log(error);
                })
                .finally(() => {
                    this.loading = false;
                });
        },
        nextLesson(index) {
            this.index++;
            this.page++;
        },

        prevLesson(index) {
            this.index--;
            this.page--;
        },

        getImageUrl(imageName) {
            return `/images/${imageName}`;
        },
    },
};
</script>

<style scoped>
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
