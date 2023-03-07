import { AuthService } from './../../services/auth.service';
import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-menu-professor',
  templateUrl: './menu-professor.component.html',
  styleUrls: ['./menu-professor.component.css']
})
export class MenuProfessorComponent implements OnInit {

  constructor( public authService: AuthService ) { }

  ngOnInit(): void {
  }

}
