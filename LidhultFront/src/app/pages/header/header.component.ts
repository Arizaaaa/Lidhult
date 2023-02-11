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

  login(){this.router.navigate(['main']); console.log(this.authService.status)}
  
  register(){this.router.navigate(['register']); console.log(this.authService.status)}

  main(){this.router.navigate(['main']); console.log(this.authService.status)}

  logout(){this.messagesService.logoutMessage();}

}
