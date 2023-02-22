import { Router } from '@angular/router';
import { RegisterDataStudent } from './../../model/register-data-student';
import { AuthService } from './../../services/auth.service';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { formatDate } from '@angular/common';

@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.css']
})
export class MainComponent implements OnInit {

  fecha = new Date();
  date = '';

  constructor(
    public authService: AuthService,
    public router: Router,
  ) { }

  cambiarContra = true;
  user:RegisterDataStudent={nick: null,name: null,surnames: null,email: null,password: null,birth_date: null}

  updateForm = new FormGroup({
    name: new FormControl('', [Validators.required]),
    surnames: new FormControl('', [Validators.required]),
    email: new FormControl('', [Validators.required]),
    date: new FormControl(),
    center: new FormControl('', [Validators.required]),
    password: new FormControl('', [Validators.required]),
  });
  
  ngOnInit(): void {
   
    if(this.authService.user.data[0]['center'] != undefined){
      this.updateForm.setValue({
        
        name: this.authService.user.data[0]['name'],
        surnames: this.authService.user.data[0]['surnames'],
        email: this.authService.user.data[0]['email'],
        date: null,
        center: this.authService.user.data[0]['center'],
        password: "",
      });
    } else {
      this.fecha = new Date(this.authService.user.data[0]['birth_date'])
      this.updateForm.setValue({
        
        name: this.authService.user.data[0]['name'],
        surnames: this.authService.user.data[0]['surnames'],
        email: this.authService.user.data[0]['email'],
        date: this.fecha,
        center: "",
        password: "",
      });
      this.date = formatDate(new Date(this.authService.user.data[0]['birth_date']),'yyyy-MM-dd','en-US')
    }
  }

  update(){
    
    let id = 0;

    if (this.updateForm.controls['name'].value != this.authService.user.data[0]['name']) { this.user['name'] = this.updateForm.controls['name'].value
    } else { this.user['name'] = this.updateForm.controls['name'].value }

    if (this.updateForm.controls['surnames'].value != this.authService.user.data[0]['surnames']) { this.user['surnames'] = this.updateForm.controls['surnames'].value
    } else { this.user['surnames'] = this.updateForm.controls['surnames'].value }

    if (this.updateForm.controls['email'].value != this.authService.user.data[0]['email']) { this.user['email'] = this.updateForm.controls['email'].value
    } else { this.user['email'] = this.updateForm.controls['email'].value }

    if (this.updateForm.controls['email'].value != this.authService.user.data[0]['email']) { this.user['email'] = this.updateForm.controls['email'].value
    } else { this.user['email'] = this.updateForm.controls['email'].value }

    if (this.updateForm.controls['center'].value != "") {
      id = 0; 
      if (this.updateForm.controls['center'].value != this.authService.user.data[0]['center']) { this.user['birth_date'] = this.updateForm.controls['center'].value
      } else { this.user['birth_date'] = this.updateForm.controls['center'].value }
    }

    if (this.updateForm.controls['date'].value != null) {
      id = 1; 
      if (this.updateForm.controls['date'].value != this.authService.user.data[0]['birth_date']) { this.user['birth_date'] = this.updateForm.controls['date'].value
      } else { this.user['birth_date'] = this.updateForm.controls['date'].value }
    }

    if (this.updateForm.controls['password'].value != "") { this.user['password'] = this.updateForm.controls['password'].value
    } else if (this.updateForm.controls['password'].value == ""){ this.user['password'] = this.authService.password }
    this.user['nick'] = this.authService.user.data[0]['nick'];
    
    this.authService.updateProfesor(this.user,id).subscribe({

      next: (value: RegisterDataStudent) => {
        console.log(value)
        this.user = value;
        this.router.navigate(['main']);
      }
    });
  }

  changePassword(){ this.cambiarContra = false }

}
