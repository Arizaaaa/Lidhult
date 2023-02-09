import { Student } from './../../model/student';
import { AuthService } from './../../services/auth.service';
import { Component, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  student: Student = {
    nick: null,
    email: null,
    name: null,
    surnames: null,
    password: null,
    birth_date: null
  };

  registerForm = new FormGroup({
    nick: new FormControl('', [Validators.required]),
    email: new FormControl('', [Validators.required, Validators.email]),
    name: new FormControl('', [Validators.required]),
    surname: new FormControl('', [Validators.required]),
    con: new FormControl('', [Validators.required]),
    conValidate: new FormControl('', [Validators.required]),
    date: new FormControl('', [Validators.required]),
  });

  constructor(
    public authService: AuthService,
    ) { 
  }

  ngOnInit(): void {
  }

  register(){

    if(this.registerForm.controls['con'].value == this.registerForm.controls['conValidate'].value){

        this.student['nick'] = this.registerForm.controls['nick'].value;
        this.student['email'] = this.registerForm.controls['email'].value
        this.student['name'] = this.registerForm.controls['name'].value
        this.student['surnames'] = this.registerForm.controls['surname'].value
        this.student['password'] = this.registerForm.controls['con'].value
        this.student['birth_date'] = this.registerForm.controls['date'].value!.toString()

      this.authService.registerStudent(this.student).subscribe({
      
        next: (value: Student) => {
          this.student = value;
          console.log(value)
        }
      });;
    }
  }
}
