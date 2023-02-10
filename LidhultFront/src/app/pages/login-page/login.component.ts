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
    private router: Router
  ) { }
  
  ngOnInit(): void {}

  login(){

    this.datos['dato'] =  this.loginForm.controls['text'].value;
    this.datos['password'] =  this.loginForm.controls['password'].value;

    this.authService.login(this.datos).subscribe({

      next: (value: LoginData) => {
        this.datos = value;
        console.log(value)
        this.router.navigate(['main']);
      }

    });



  }

}
