import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '@/stores/authStore';
import HomeView                           from '@/views/Home/HomeView.vue';
import CadastroUsuario                    from '@/views/Usuarios/Cadastrar/CadastroUsuarioView.vue';
import LocalDetalheView                   from '@/views/Local/LocalDetalheView.vue';
import AtividadesView                     from '@/views/atividades/AtividadesView.vue';
import InstalacoesView                    from '@/views/Instalacoes/InstalacoesView.vue';
import LogsView                           from '@/views/Log/LogsView.vue';
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
      meta: { requiresAuth: true },
    },
    {
      path: '/local/:id',
      name: 'local-detalhe',
      component: LocalDetalheView,
      props: true,
      meta: { requiresAuth: true },
    },
    {
      path: '/atividades',
      name: 'atividades',
      component: AtividadesView,
      meta: { requiresAuth: true },
    },
    {
      path: '/instalacoes',
      name: 'instalacoes',
      component: InstalacoesView,
      meta: { requiresAuth: true },
    },
    {
      path: '/logs',
      name: 'logs',
      component: LogsView,
      meta: { requiresAuth: true },
    },
    {
      path: '/usuarios',
      name: 'usuarios',
      component: UsuariosView,
      meta: { requiresAuth: true },
    },
    {
      path: "/usuarios/cadastrar",
      name: "cadastroUsuario",
      component: CadastroUsuario,
      meta: { requiresAuth: true },
    },
    {
      path: '/usuarios/perfil',
      name: 'perfil',
      component: PerfilView,
      meta: { requiresAuth: true },
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView,
      meta: { requiresAuth: false },
    },
    {
      path: '/recuperar-senha',
      name: 'recuperar-senha',
      component: RecuperarSenhaView,
      meta: { requiresAuth: false },
    },
    {
      path: '/nova-senha',
      name: 'nova-senha',
      component: NovaSenhaView,
      meta: { requiresAuth: false },
    },
  ],
})

// Track if we are checking auth to avoid duplicate checks
let isCheckingAuth = false;

// Navigation guard to check authentication
router.beforeEach(async (to, from, next) => {
  const authStore = useAuthStore();
  const requiresAuth = to.meta.requiresAuth as boolean | undefined;

  // Public routes are always accessible
  if (requiresAuth === false) {
    return next();
  }

  // If no auth is required, proceed
  if (requiresAuth !== true) {
    return next();
  }

  // For protected routes, verify session
  if (isCheckingAuth) {
    return next();
  }

  isCheckingAuth = true;

  try {
    // Check if already has user data
    if (!authStore.isAuthenticated && !authStore.isLoading) {
      // Make a simple API call to verify authentication
      await authStore.checkAuth();
    }

    isCheckingAuth = false;

    // If still not authenticated, redirect to login
    if (!authStore.isAuthenticated) {
      return next({ name: 'login' });
    }

    return next();
  } catch {
    isCheckingAuth = false;
    // On error, clear user and redirect to login
    authStore.clearUser();
    return next({ name: 'login' });
  }
});

export default router
