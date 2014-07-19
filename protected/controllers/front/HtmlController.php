<?php

class HtmlController extends Controller
{

    public function actionCreateTask()
	{
      $this->render('createtask' );
    }
    public function actiontaskpreview()
	{
      $this->render('taskpreview' );
    } 
	 public function actionviewportfolio()
	{
      $this->render('viewportfolio' );
    }  
	public function actiontasklist()
	{
      $this->render('tasklist' );
    } 
	public function actionnotification()
	{
      $this->render('notification' );
    }
	public function actiontaskeraboutus()
	{
      $this->render('taskeraboutus' );
    }
	public function actiontaskerlist()
	{
      $this->render('taskerlist' );
    }
	public function actiontaskdetailandpraposal()
	{
      $this->render('taskdetailandpraposal' );
    }	
	public function actiontaskdetailpop()
	{
      $this->render('taskdetailpop' );
    }
	public function actionproposallist()
	{
      $this->render('proposallist' );
    }
	public function actionproposaldetail()
	{
      $this->render('proposaldetail' );
    }
	public function actiontasksearch()
	{
      $this->render('tasksearch' );
    }
	public function actionmytaskforposter()
	{
      $this->render('mytaskforposter' );
    }
	public function actionmytaskfortasker()
	{
      $this->render('mytaskfortasker' );
    }
	public function actionpublictaskersearch()
	{
      $this->render('publictaskersearch' );
    }
	public function actioninbox()
	{
      $this->render('inbox' );
    }
	public function actioninboxdetail()
	{
      $this->render('inboxdetail' );
    }
	public function actionmyproposaldetail()
	{
      $this->render('myproposaldetail' );
    }
	public function actionsettingsnotifications()
	{
      $this->render('settingsnotifications' );
    }
}