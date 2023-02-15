import { Router } from '@angular/router';
import { AuthService } from './auth.service';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class MessagesService {

  mensajeLogout = true;
  mensajeLogin = true;
  mensajeRegister = true;

  constructor(
    public authService:AuthService,
    private router:Router
    ) { }

  logoutMessage(){ this.mensajeLogout = false;}

  logout(){
    this.authService.status = 0; 
    this.authService.stud = true;
    this.authService.prof = true;
    this.router.navigate(['login']);
  }

  loginFail(){ this.mensajeLogin = false }

  registerFail(){ this.mensajeRegister = false }
}
