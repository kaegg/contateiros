import { createRouter, createWebHistory } from 'vue-router';
import CadastroUsuario from '../views/CadastroUsuarioView.vue';
import HomeView        from '../views/HomeView.vue';
import LocalDetalheView from '../views/LocalDetalheView.vue';
import AtividadesView from '../views/AtividadesView.vue';
import InstalacoesView from '../views/InstalacoesView.vue';
import LogsView from '../views/LogsView.vue';
import UsuariosView from '../views/UsuariosView.vue';
import PerfilView from '../views/PerfilView.vue';
import LoginView from '../views/LoginView.vue';
import RecuperarSenhaView from '../views/RecuperarSenhaView.vue';
import NovaSenhaView from '../views/NovaSenhaView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    // {
    //   path: '/about',
    //   name: 'about',
    //   // route level code-splitting
    //   // this generates a separate chunk (About.[hash].js) for this route
    //   // which is lazy-loaded when the route is visited.
    //   component: () => import('../views/AboutView.vue'),
    // },
    {
      path: "/cadastrar",
      name: "cadastroUsuario",
      component: CadastroUsuario,
    },
    {
      path: '/local/:id',
      name: 'local-detalhe',
      component: LocalDetalheView,
      props: true
    },
    {
      path: '/atividades',
      name: 'atividades',
      component: AtividadesView,
    },
    {
      path: '/instalacoes',
      name: 'instalacoes',
      component: InstalacoesView,
    },
    {
      path: '/logs',
      name: 'logs',
      component: LogsView,
    },
    {
      path: '/usuarios',
      name: 'usuarios',
      component: UsuariosView,
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: PerfilView,
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
    },
    {
      path: '/recuperar-senha',
      name: 'recuperar-senha',
      component: RecuperarSenhaView,
    },
    {
      path: '/nova-senha',
      name: 'nova-senha',
      component: NovaSenhaView,
    },
  ],
})

export default router
