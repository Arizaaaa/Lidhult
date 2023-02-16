import { MessagesService } from './../../services/messages.service';
import { AuthService } from '../../services/auth.service';
import { Router } from '@angular/router';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {

  constructor( 
    public authService : AuthService,
    public messagesService : MessagesService,
    private router: Router) { }

  ngOnInit(): void {
  }

  login(){this.router.navigate(['perfil']); }
  
  register(){this.router.navigate(['register']);}

  perfil(){this.router.navigate(['perfil']);}

  logout(){this.messagesService.logoutMessage();}

}
