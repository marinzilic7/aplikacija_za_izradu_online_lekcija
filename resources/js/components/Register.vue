<template>
    <div clas="container ">
        <div class="d-flex justify-content-center mt-5">
            <form class="col-lg-4 border shadow-lg p-5 bg-light">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"
                        >Ime</label
                    >
                    <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase ime"
                    />

                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label"
                        >Prezime</label
                    >
                    <input
                        type="email"
                        class="form-control"
                        id="exampleInputEmail1"
                        aria-describedby="emailHelp"
                        placeholder="Unesite vase prezime"
                    />

                </div>
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
                    />

                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label"
                        >Lozinka</label
                    >
                    <input
                        type="password"
                        class="form-control"
                        id="exampleInputPassword1"
                        placeholder="Unesite vase lozinku"
                    />
                </div>

                <button type="submit" class="btn btn-primary w-100">Registriraj se</button>
                <p class="mt-3 text-center">Ako imate račun, onda kliknite na <span><a class="text-info text-decoration-none fw-bold" href="/login">Prijava</a></span></p>
            </form>
        </div>
    </div>
</template>

<script setup></script>

<style lang="scss" scoped></style>
