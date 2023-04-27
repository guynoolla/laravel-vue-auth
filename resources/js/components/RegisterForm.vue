<template>
    <form ref="registerForm" @submit.prevent="onSubmit">
        <slot></slot>

        <div id="errors-list"></div>

        <div class="form-group row">
            <label for="first_name" class="col-md-4 col-form-label text-md-right">Имя</label>
            <div class="col-md-6">
                <input type="text" id="first_name" class="form-control" v-model="form.first_name" required autofocus>
                <span class="text-danger">{{ errors.first_name }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="last_name" class="col-md-4 col-form-label text-md-right">Фамилия</label>
            <div class="col-md-6">
                <input type="text" id="last_name" class="form-control" v-model="form.last_name" required autofocus>
                <span class="text-danger">{{ errors.last_name }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">Email адрес</label>
            <div class="col-md-6">
                <input type="text" id="email" class="form-control" v-model="form.email" required autofocus>
                <span class="text-danger">{{ errors.email }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
            <div class="col-md-6">
                <input type="password" id="password" class="form-control" v-model="form.password" required>
                <span class="text-danger">{{ errors.password }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="confirm_password" class="col-md-4 col-form-label text-md-right">Повторить пароль</label>
            <div class="col-md-6">
                <input type="password" id="confirm_password" class="form-control" v-model="form.confirm_password" required>
                <span class="text-danger">{{ errors.confirm_password }}</span>
            </div>
        </div>

        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Register
            </button>
        </div>
    </form>
</template>

<script>
    import axios from 'axios';

    export default {
        data() {
            return {
                form : {},
                errors: []
            }
        },
        props: ['action'],
        methods: {
            onSubmit : function() {
                axios({
                    method: "post",
                    url: this.action,
                    data: this.form

                }).then((res) => {
                    const data = res.data;

                    if (!data.status) {
                        let errors = [];
                        for (const key in data.errors) {
                            errors[key] = data.errors[key].join(" ");
                        }
                        this.errors = errors;

                    } else {
                        window.location.replace(data.redirect);
                    }
                });
            }
        }
    }
</script>
