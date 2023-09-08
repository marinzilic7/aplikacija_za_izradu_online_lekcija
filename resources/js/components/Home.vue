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
    <div>Home</div>
</template>

<script>
import { mapState } from "vuex";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
    data() {
        return {};
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
};
</script>

<style lang="scss" scoped></style>
