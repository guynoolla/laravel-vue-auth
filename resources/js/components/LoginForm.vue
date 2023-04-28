<template>
    <form @submit.prevent="onSubmit">
        <slot></slot>

        <div class="text-danger py-4">{{ errors.invalid_credentials }}</div>

        <div class="form-group row">
            <label for="email" class="col-md-4 col-form-label text-md-right">Email адрес</label>
            <div class="col-md-6">
                <input type="text" id="email" class="form-control" v-model="form.email" required autofocus>
                <span class="text-danger">{{ errors.email }}</span>
            </div>
        </div>

        <div class="form-group row">
            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
            <div class="col-md-6">
                <input type="password" id="password" class="form-control" v-model="form.password">
                <span class="text-danger">{{ errors.password }}</span>
            </div>
        </div>

        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary">
                Login
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
                    console.log('data', data);

                    if (data.status) {
                        window.location.replace(data.redirect);
                    } else {
                        let errors = [];
                        for (const key in data.errors) {
                            if (errors.length > 0) {
                                errors[key] = data.errors[key].join(" ").toString();
                            } else {
                                errors[key] = data.errors[key].toString();
                            }
                        }
                        this.errors = errors;
                    }
                });
            }
        }
    }
</script>