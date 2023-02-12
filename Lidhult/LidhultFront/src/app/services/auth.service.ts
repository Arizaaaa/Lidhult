import { LoginData } from './../model/login-data';
import { RegisterDataStudent } from './../model/register-data-student';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { filter, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {                                                                                                                                                

  readonly registeStudentrUrl = "http://localhost:8000/api/createStudent"
  readonly registeProfessorUrl = "http://localhost:8000/api/createProfessor"
  readonly loginUrl = "http://localhost:8000/api/login"
  readonly updateStudentUrl = "http://localhost:8000/api/updateStudent"
  readonly updateProfessorUrl = "http://localhost:8000/api/updateProfessor"

  status = 0;
  user : any;
  prof = true;
  stud = true;
  password : any;

  constructor(public http: HttpClient) { }

  registerStudent(student:RegisterDataStudent) : Observable<RegisterDataStudent>{
    
    this.password = student['password']
    return this.http.post<RegisterDataStudent>(this.registeStudentrUrl, student).pipe(
      filter((value: any) => {
        let found = false;
        if(value != null){
          found = true
        }else{
          found = false
        }
        this.status = value['status'];
        this.user = value;
        return found
        })
    );
  }
  registerProfessor(professor:RegisterDataStudent) : Observable<RegisterDataStudent>{
    
    this.password = professor['password']
    return this.http.post<RegisterDataStudent>(this.registeProfessorUrl, professor).pipe(
      filter((value: any) => {
        let found = false;
        if(value != null){
          found = true
        }else{
          found = false
        }
        this.status = value['status'];
        this.user = value;
        return found
        })
    );
  }

  updateProfesor(profesor:RegisterDataStudent,id:number) : Observable<RegisterDataStudent>{

    console.log(profesor)
    if (id == 0) {
      return this.http.post<RegisterDataStudent>(this.updateProfessorUrl, profesor).pipe(
        filter((value: any) => {
          let found = false;
          if(value != null){
            found = true
          }else{
            found = false
          }
          this.status = value['status'];
          this.user = value;
          return found
          })
      );
    } else {
      return this.http.post<RegisterDataStudent>(this.updateStudentUrl, profesor).pipe(
        filter((value: any) => {
          let found = false;
          if(value != null){
            found = true
          }else{
            found = false
          }
          this.status = value['status'];
          this.user = value;
          return found
          })
      );
      }
    }
    


  login(data:LoginData) : Observable<LoginData>{
    
    this.password = data['password']
    return this.http.post<LoginData>(this.loginUrl, data).pipe(
      filter((value: any) => {
        let found = false;
        if(value != null){
          found = true
        }else{
          found = false
        }
        this.status = value['status'];
        this.user = value;
        return found
        })
    );
  }

  elegirProf(){ this.prof = false;}
  elegirStud(){ this.stud = false;}
}
