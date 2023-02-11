import { MessagesService } from './../../services/messages.service';
import { LoginData } from './../../model/login-data';
import { AuthService } from './../../services/auth.service';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  loginForm = new FormGroup({
      text: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required]),
    });

  datos : LoginData = {
    dato: null,
    password: null
  };

  constructor(  
    public authService: AuthService,
    public messageService: MessagesService,
    private router: Router
  ) { }
  
  ngOnInit(): void {}

  login(){
    this.datos['dato'] =  this.loginForm.controls['text'].value;
    this.datos['password'] =  this.loginForm.controls['password'].value;

    this.authService.login(this.datos).subscribe({

      next: (value: LoginData) => {
        this.datos = value;
        this.comporbacionLogin(value);
        this.router.navigate(['main']);
      }
    });
  }

  comporbacionLogin(value:any){ 
    
    if (value['status'] == 0){ 
      this.messageService.loginFail() 
    } else {
      this.messageService.mensajeLogin = true
    }
  }

  cerrar(){ this.messageService.mensajeLogin = true }
}
