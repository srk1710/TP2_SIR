import Vue from "vue";
import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [{
        path: "/",
        name: "home",
        component: () =>
            import ("../views/Home.vue")
    },
    {
        path: "/login",
        name: "login",
        component: () =>
            import ("../views/Login.vue")
    },
    {
        path: "/perfil",
        name: "perfil",
        component: () =>
            import ("../views/Perfil.vue")
    },
    {
        path: "/nova",
        name: "nova",
        component: () =>
            import ("../views/NovaPub.vue")
    },
    {
        path: "/pub",
        name: "pub",
        component: () =>
            import ("../views/Publicacao.vue"),
        props: true
    },
    {
        path: "/p",
        name: "perfilGeral",
        component: () =>
            import ("../views/PerfilGeral.vue"),
        props: true
    },
    {
        path: "/registar",
        name: "registar",
        component: () =>
            import ("../views/Registar.vue"),
        props: true
    }
];

const router = new VueRouter({
    mode: "history",
    base: process.env.BASE_URL,
    routes
});

router.beforeResolve((to, from, next) => {
    if (to.name) {
        NProgress.start()
    }
    next()
})

router.afterEach((to, from) => {
    NProgress.done()
})

export default router;