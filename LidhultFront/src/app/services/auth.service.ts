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
  readonly loginStudentUrl = "http://localhost:8000/api/login"
  readonly loginProfessorUrl = "http://localhost:8000/api/"

  status = 0;

  constructor(public http: HttpClient) { }

  registerStudent(student:RegisterDataStudent) : Observable<RegisterDataStudent>{

    return this.http.post<RegisterDataStudent>(this.registeStudentrUrl, student).pipe(
      filter((value: any) => {
        let found = false;
        if(value != null){
          found = true
        }else{
          found = false
        }
        this.status = value['status'];
        return found
        })
    );
  }

  login(data:LoginData) : Observable<LoginData>{

    console.log(data);
    
    return this.http.post<LoginData>(this.loginStudentUrl, data).pipe(
      filter((value: any) => {
        let found = false;
        if(value != null){
          found = true
        }else{
          found = false
        }
        this.status = value['status'];
        return found
        })
    );

  }
}
