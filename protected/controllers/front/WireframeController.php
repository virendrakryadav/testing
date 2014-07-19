<?php

class WireframeController extends Controller
{

public $layout='//layouts/noheader';
    public function actionsettingsnotifications()
    {
        //$this->render('createtask' );
        $this->render('settingsnotifications');
    }
	
    public function actionnewvirtualproject()
    {
        //$this->render('createtask' );
        $this->render('newvirtualproject');
    }
	
    public function actionchoosesubcategoryvirtual()
    {
        //$this->render('createtask' );
        $this->render('choosesubcategoryvirtual');
    }
	
    public function actionvirtualprojectdetails()
    {
        //$this->render('createtask' );
        $this->render('virtualprojectdetails');
    }	
		
    public function actionprojectmarkcompletfortasker()
    {
        //$this->render('createtask' );
        $this->render('projectmarkcompletfortasker');
    }
	
    public function actionprojectconfirmreceiptstfortasker()
    {
        //$this->render('createtask' );
        $this->render('projectconfirmreceiptstfortasker');
    }
	
    public function actionprojectratereviewfortasker()
    {
        //$this->render('createtask' );
        $this->render('projectratereviewfortasker');
    }
	
    public function actionprojectpaymentfortasker()
    {   //$this->render('createtask' );
        $this->render('projectpaymentfortasker');
    }
	
    public function actionnotifications()
    {
        //$this->render('createtask' );
        $this->render('notifications');
    }	
	
    public function actionnewinstantproject()
    {
        //$this->render('createtask' );
        $this->render('newinstantproject');
    }
	
    public function actioninstantprojectdetails()
    {
        //$this->render('createtask' );
        $this->render('instantprojectdetails');
    }
	
    public function actionfindtasker()
    {
        //$this->render('createtask' );
        $this->render('findtasker');
    }
	
    public function actionfindtask()
    {
        //$this->render('createtask' );
        $this->render('findtask');
    }
	
    public function actionmytaskforposter()
    {
        //$this->render('createtask' );
        $this->render('mytaskforposter');
    }
	
    public function actionmytaskfordoer()
    {
        //$this->render('createtask' );
        $this->render('mytaskfordoer');
    }
	
    public function actionviewproposal()
    {
        //$this->render('createtask' );
        $this->render('viewproposal');
    }
    public function actionproposallist()
    {
        //$this->render('createtask' );
        $this->render('proposallist');
    }
	
    public function actionproposaldetail()
    {
        //$this->render('createtask' );
        $this->render('proposaldetail');
    }
	
    public function actioninbox()
    {
        //$this->render('createtask' );
        $this->render('inbox');
    } 
	
	public function actionprojectlive()
    {
        //$this->render('createtask' );
        $this->render('projectlive');
    }	
	
	public function actionprojectliveapply()
    {
        //$this->render('createtask' );
        $this->render('projectliveapply');
    }
	
	public function actionsearchproject()
    {
        //$this->render('createtask' );
        $this->render('searchproject');
    }
	
	public function actionsearchprojectgridview()
    {
        //$this->render('createtask' );
        $this->render('searchprojectgridview');
    }
	
	public function actionproposallistposter()
    {
        //$this->render('createtask' );
        $this->render('proposallistposter');
    }	
	
	public function actionproposaldetailposter()
    {
        //$this->render('createtask' );
        $this->render('proposaldetailposter');
    }
	
	public function actionproposaldetailposter1()
    {
        //$this->render('createtask' );
        $this->render('proposaldetailposter1');
    }
	
	public function actionpublicprofile()
    {
        //$this->render('createtask' );
        $this->render('publicprofile');
    }
	
	public function actionteamsetting()
    {
        //$this->render('createtask' );
        $this->render('teamsetting');
    }
	
	public function actioncreateteam()
    {
        //$this->render('createtask' );
        $this->render('createteam');
    }
	
	public function actionteamdetails()
    {
        //$this->render('createtask' );
        $this->render('teamdetails');
    }
	
	public function actionteamprojectdetails()
    {
        //$this->render('createtask' );
        $this->render('teamprojectdetails');
    }
	
	public function actionteammessagesdetails()
    {
        //$this->render('createtask' );
        $this->render('teammessagesdetails');
    }
	
	public function actionsettings()
    {
        //$this->render('createtask' );
        $this->render('settings');
    }
	
	public function actionlocations()
    {
        //$this->render('createtask' );
        $this->render('locations');
    }
	
	public function actionaccountsetting()
    {
        //$this->render('createtask' );
        $this->render('accountsetting');
    }
	
	public function actionemailpassword()
    {
        //$this->render('createtask' );
        $this->render('emailpassword');
    }
	
	public function actionprofilesetting()
    {
        //$this->render('createtask' );
        $this->render('profilesetting');
    }
	
	public function actionmoney()
    {
        //$this->render('createtask' );
        $this->render('money');
    }
	
	public function actionmoneyactivity()
    {
        //$this->render('createtask' );
        $this->render('moneyactivity');
    }
	
	public function actionmoneyreports()
    {
        //$this->render('createtask' );
        $this->render('moneyreports');
    }
	public function actionmoneytaxrecords()
    {
        //$this->render('createtask' );
        $this->render('moneytaxrecords');
    }
	
	public function actionlanding_page()
    {
        //$this->render('createtask' );
        $this->render('landing_page');
    }
}