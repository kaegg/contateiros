import { createRouter, createWebHistory } from 'vue-router';
import HomeView                           from '@/views/Home/HomeView.vue';
import CadastroUsuario                    from '@/views/Usuarios/Cadastrar/CadastroUsuarioView.vue';
import LocalDetalheView                   from '@/views/Local/LocalDetalheView.vue';
import AtividadesView                     from '@/views/atividades/AtividadesView.vue';
import InstalacoesView                    from '@/views/Instalacoes/InstalacoesView.vue';
import LogsView                           from '@/views/Logs/LogsView.vue';
import UsuariosView                       from '@/views/Usuarios/UsuariosView.vue';
import PerfilView                         from '@/views/Usuarios/Perfil/PerfilView.vue';
import LoginView                          from '@/views/Login/LoginView.vue';
import RecuperarSenhaView                 from '@/views/RecuperarSenha/RecuperarSenhaView.vue';
import NovaSenhaView                      from '@/views/NovaSenha/NovaSenhaView.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
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
      path: "/usuarios/cadastrar",
      name: "cadastroUsuario",
      component: CadastroUsuario,
    },
    {
      path: '/usuarios/perfil',
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
