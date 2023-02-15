import { Component } from '@angular/core';
import { MessagesService } from './services/messages.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'LidhultFront';

  constructor(
    public messageService:MessagesService
  ){}

  salir(eleccion:number){

    if(eleccion == 1){

      this.messageService.logout();
      this.messageService.mensajeLogout = true;

    } else if(eleccion == 2) {

      this.messageService.mensajeLogout = true;

    }
  }

}
