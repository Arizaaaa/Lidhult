import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { filter, Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class CharacterService {

  constructor(public http: HttpClient) { }

  readonly getCharacteruUrl = "http://localhost:8000/api/indexCharacters"
  data:any;

  imagenes() : Observable<any>{

    return this.http.get<any>(this.getCharacteruUrl).pipe(
      filter((value: any) => {
        let found = false;
        if(value != null){
          found = true
        }else{
          found = false
        }
        this.data = value;
        return found
        })
    );
  }
}
