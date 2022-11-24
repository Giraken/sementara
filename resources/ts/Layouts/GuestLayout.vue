<template>
    <div class="auth-page-wrapper pt-5">
        <div id="auth-particles" class="auth-one-bg-position auth-one-bg">
            <div class="bg-overlay"></div>
        </div>

        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <router-link
                                    class="d-inline-block auth-logo"
                                    to="/"
                                >
                                    <img
                                        alt=""
                                        height="20"
                                        src="@assets/images/logo-light.png"
                                    />
                                </router-link>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">
                                Premium Admin & Dashboard Template
                            </p>
                        </div>
                    </div>
                </div>

                <slot/>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-white">
                                © PT BEE MATA INDONESIA -
                                {{ new Date().getFullYear() }}. All rights
                                reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script lang="ts">
import {defineComponent} from "vue"

export default defineComponent({
    components: {},

    data() {
        return {
            showingNavigationDropdown: false,
        }
    },

    mounted() {
        var password = document.getElementById("password-input") as HTMLInputElement
        password.onchange = this.validatePassword
        document.querySelectorAll("form .auth-pass-inputgroup")
            .forEach(function (item) {
                item.querySelectorAll(".password-addon").forEach(function (subitem) {
                    subitem.addEventListener("click", function () {
                        var passwordInput = item.querySelector(".password-input") as HTMLInputElement
                        if (passwordInput.type === "password") {
                            passwordInput.type = "text"
                        } else {
                            passwordInput.type = "password"
                        }
                    })
                })
            })
        var myInput = <HTMLInputElement>document.getElementById("password-input")
        var letter = <HTMLInputElement>document.getElementById("pass-lower")
        var capital = <HTMLInputElement>document.getElementById("pass-upper")
        var number = <HTMLInputElement>document.getElementById("pass-number")
        var length = <HTMLInputElement>document.getElementById("pass-length")

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function () {
            const passwordContain = <HTMLInputElement>document.getElementById("password-contain")
            passwordContain.style.display = "block"
        }

        // When the user clicks outside of the password field, hide the password-contain box
        myInput.onblur = function () {
            const passwordContain = <HTMLInputElement>document.getElementById("password-contain")
            passwordContain.style.display = "none"
        }

        // When the user starts to type something inside the password field
        myInput.onkeyup = function () {
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g
            if (myInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid")
                letter.classList.add("valid")
            } else {
                letter.classList.remove("valid")
                letter.classList.add("invalid")
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g
            if (myInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid")
                capital.classList.add("valid")
            } else {
                capital.classList.remove("valid")
                capital.classList.add("invalid")
            }

            // Validate numbers
            var numbers = /[0-9]/g
            if (myInput.value.match(numbers)) {
                number.classList.remove("invalid")
                number.classList.add("valid")
            } else {
                number.classList.remove("valid")
                number.classList.add("invalid")
            }

            // Validate length
            if (myInput.value.length >= 8) {
                length.classList.remove("invalid")
                length.classList.add("valid")
            } else {
                length.classList.remove("valid")
                length.classList.add("invalid")
            }
        }
    },

    methods: {
        switchToTeam(team) {
            this.$inertia.put(
                route("current-team.update"),
                {
                    team_id: team.id,
                },
                {
                    preserveState: false,
                }
            )
        },

        logout() {
            this.$inertia.post(route("logout"))
        },
        validatePassword() {
            // passowrd match
            var password = <HTMLInputElement>document.getElementById("password-input"),
                confirm_password = <HTMLInputElement>document.getElementById("confirm-password-input")

            //Password validation

            if (password.value != confirm_password.value) {
                confirm_password.setCustomValidity("Passwords Don't Match")
            } else {
                confirm_password.setCustomValidity("")
            }
        },
    },
})
</script>
