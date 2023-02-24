import { AuthGuard } from './guards/auth.guard';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './pages/login-page/login.component';
import { PerfilComponent } from './pages/perfil-page/perfil.component';
import { RegisterComponent } from './pages/register-page/register.component';
import { SelectComponent } from './pages/select/select.component';
import { RankingComponent } from './pages/ranking-page/ranking.component';
import { HomeComponent } from './pages/home-page/home.component';

const routes: Routes = [

  {path: 'login',
  component: LoginComponent},
  {path: 'select',
  component: SelectComponent},
  {path: 'register',
  component:  RegisterComponent},
  {path: 'ranking',
  component: RankingComponent,
  canActivate: [AuthGuard]},
  {path: 'home',
  component: HomeComponent, 
  canActivate: [AuthGuard]},
  {path: 'perfil',
  component: PerfilComponent,
  canActivate: [AuthGuard]
  },
  { path: '**', redirectTo: '/', pathMatch: 'full' }

];


@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
