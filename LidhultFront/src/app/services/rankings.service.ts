import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { filter, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class RankingsService {

  constructor(public http: HttpClient) { }

  showRankingsUrl:any
  showRankingUrl:any
  sendRequestUrl:any
  rankigSelected:any
  ver:boolean = false
  
  rankingsUsuarios(id:number) : Observable<any>{
   this.showRankingsUrl = "http://localhost:8000/api/showStudentRanking/"+id
    
    return this.http.get<any>(this.showRankingsUrl).pipe(
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

  rankingsProfesor(id:number) : Observable<any>{

    this.showRankingsUrl = "http://localhost:8000/api/showProfessorRanking/"+id
     
     return this.http.get<any>(this.showRankingsUrl).pipe(
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

  verRankings(id:number) : Observable<any>{
    this.showRankingUrl = "http://localhost:8000/api/indexUsers/"+id
     
     return this.http.get<any>(this.showRankingUrl).pipe(
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
   
   unirseRankings(code:any, student_id:any) : Observable<any>{
    this.sendRequestUrl = "http://localhost:8000/api/sendRequest"
    let request = {code, student_id};
     return this.http.post<any>(this.sendRequestUrl,request).pipe(
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
