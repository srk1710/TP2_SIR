<template>
    <div>    
        <h2>Login</h2>    
        <form v-on:submit="login">    
            <input type="text" name="email" /><br>    
            <input type="password" name="password" /><br>    
            <input type="submit" value="Login" />    
        </form>    
    </div>
</template>

<script>
    import router from "../router"    
    import axios from "axios"    
    export default {    
        name: "Login",    
        methods: {    
            login: (e) => {    
                e.preventDefault()    
                let email = "user@email.com"   
                let password = "password"    
                let login = () => {    
                    let data = {    
                        email: email,    
                        password: password    
                    }    
                    axios.get("http://localhost:8081/sir/TP2_SIR/api/login.php", data)    
                        .then((response) => {    
                            console.log(response)    
                            //router.push("/home")    
                        })
                        .catch((errors) => {    
                            console.log(errors)    
                        })    
                }    
                login()    
            }    
        }    
    }
</script>
