import { Student } from './../model/student';
import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { filter, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class AuthService {                                                                                                                                                

  readonly registeStudentrUrl = "http://localhost:8000/api/createStudent"

  constructor(public http: HttpClient) { }

  registerStudent(student:Student) : Observable<Student>{
    console.log(student);
   return this.http.post<Student>(this.registeStudentrUrl, student).pipe(
    filter((value: any) => {
      let found = false;
      if(value != null){
         found = true
      }else{
         found = false
      }
      return found
    })
  );
  }

}
