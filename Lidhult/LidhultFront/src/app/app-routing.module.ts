import { AuthGuard } from './guards/auth.guard';
import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { LoginComponent } from './pages/login-page/login.component';
import { MainComponent } from './pages/main-page/main.component';
import { RegisterComponent } from './pages/register-page/register.component';
import { SelectComponent } from './pages/select/select.component';

const routes: Routes = [

  {path: 'login',
  component: LoginComponent},
  {path: 'select',
  component: SelectComponent},
  {path: 'register',
  component:  RegisterComponent},
  {path: 'main',
  component: MainComponent,
  canActivate: [AuthGuard]
  },
  { path: '**', redirectTo: '/', pathMatch: 'full' }

];


@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
