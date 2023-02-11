import { Router } from '@angular/router';
import { RegisterDataStudent } from './../../model/register-data-student';
import { AuthService } from './../../services/auth.service';
import { Component, OnInit } from '@angular/core';
import { AbstractControl, FormControl, FormGroup, Validators } from '@angular/forms';
import { MessagesService } from 'src/app/services/messages.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {

  public status = 0; 
  pasar = true;
  profesor = true;

  student: RegisterDataStudent = {nick: null,email: null,name: null,surnames: null,password: null,birth_date: null};

  registerForm = new FormGroup({
    nick: new FormControl('', [Validators.required]),
    email: new FormControl('', [Validators.required, Validators.email]),
    name: new FormControl('', [Validators.required]),
    surname: new FormControl('', [Validators.required]),
    con: new FormControl('', [Validators.required]),
    conValidate: new FormControl('', [Validators.required]),
    date: new FormControl('', [Validators.required]),
  }, [this.passwordMatch('con','conValidate' )]);

  constructor(
    public authService: AuthService,
    public messageService: MessagesService,
    private router: Router

    ) { 
  }
  ngOnInit(): void {}

  passwordMatch(password:string, passwordVal:string){

    return function(form:AbstractControl){
      const val = form.get(password)?.value
      const confirmVal = form.get(passwordVal)?.value

      if(val === confirmVal){
        return null;
      }
      return {passwordMismatchError:true}
    }

  }

  register(){

    if(this.authService.stud){
      if(this.registerForm.controls['con'].value == this.registerForm.controls['conValidate'].value){

        this.student['nick'] = this.registerForm.controls['nick'].value;
        this.student['email'] = this.registerForm.controls['email'].value
        this.student['name'] = this.registerForm.controls['name'].value
        this.student['surnames'] = this.registerForm.controls['surname'].value
        this.student['password'] = this.registerForm.controls['con'].value
        this.student['birth_date'] = this.registerForm.controls['date'].value!.toString()

      this.authService.registerStudent(this.student).subscribe({
      
        next: (value: any) => {
          this.student = value;
          if(value['status'] == 1){
            this.status = value['status']
            this.router.navigate(['main']);
            }
            this.comprobacionRegister(value);
          }
        });
      }
    } else {
      
      if(this.registerForm.controls['con'].value == this.registerForm.controls['conValidate'].value){

        this.student['nick'] = this.registerForm.controls['nick'].value;
        this.student['email'] = this.registerForm.controls['email'].value
        this.student['name'] = this.registerForm.controls['name'].value
        this.student['surnames'] = this.registerForm.controls['surname'].value
        this.student['password'] = this.registerForm.controls['con'].value
        this.student['birth_date'] = this.registerForm.controls['date'].value!.toString()

      this.authService.registerProfessor(this.student).subscribe({
      
        next: (value: any) => {
          this.student = value;
          if(value['status'] == 1){
            this.status = value['status']
            this.router.navigate(['main']);
          }
          this.comprobacionRegister(value);
        }
      });
    }

    }
  }
  comprobacionRegister(value:any){ 
    console.log('hola1')
    
    if (value['status'] == 0){ 
      console.log('hola')
      this.messageService.registerFail() 
      
    } else {
      this.messageService.mensajeRegister = true
    }
  }

  cerrar(){ this.messageService.mensajeRegister = true }

}
