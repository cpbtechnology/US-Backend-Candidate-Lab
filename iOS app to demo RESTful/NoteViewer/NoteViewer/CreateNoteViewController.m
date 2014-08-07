//
//  CreateNoteViewController.m
//  NoteViewer
//
//  Created by Evan Spielberg on 8/7/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import "CreateNoteViewController.h"

@interface CreateNoteViewController ()

@end

@implementation CreateNoteViewController
@synthesize userNameString = _userNameString;
@synthesize userIDString = _userIDString;
@synthesize userPasswordString = _userPasswordString;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    // Do any additional setup after loading the view.
    
    UIToolbar* noteTitleToolbar = [[UIToolbar alloc]initWithFrame:CGRectMake(0, 0, 320, 50)];
    noteTitleToolbar.barStyle = UIBarStyleBlackTranslucent;
    noteTitleToolbar.items = [NSArray arrayWithObjects:[[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil],
                                    [[UIBarButtonItem alloc]initWithTitle:@"Done" style:UIBarButtonItemStyleDone target:self action:@selector(doneWithUserNotesTitleField)],
                                    nil];
    [noteTitleToolbar sizeToFit];
    self.noteTitleView.inputAccessoryView = noteTitleToolbar;

    
    
    UIToolbar* noteDescriptionToolbar = [[UIToolbar alloc]initWithFrame:CGRectMake(0, 0, 320, 50)];
    noteDescriptionToolbar.barStyle = UIBarStyleBlackTranslucent;
    noteDescriptionToolbar.items = [NSArray arrayWithObjects:[[UIBarButtonItem alloc]initWithBarButtonSystemItem:UIBarButtonSystemItemFlexibleSpace target:nil action:nil],
                                    [[UIBarButtonItem alloc]initWithTitle:@"Done" style:UIBarButtonItemStyleDone target:self action:@selector(doneWithUserNotesDescriptionField)],
                                    nil];
    [noteDescriptionToolbar sizeToFit];
    self.noteDescriptionView.inputAccessoryView = noteDescriptionToolbar;

    
    
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}


#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
    [self saveNote];
}




- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.noteTitleView resignFirstResponder];
    
    [self.noteDescriptionView resignFirstResponder];
    
    
    
}

-(void)doneWithUserNotesTitleField{
    [self.noteTitleView resignFirstResponder];
}


-(void)doneWithUserNotesDescriptionField{
    //  NSString *textFromTheKeyboard = self.userNameTextField.text;
    //  NSLog(@"Weight = %@",textFromTheKeyboard);
    [self.noteDescriptionView resignFirstResponder];
}


-(void)saveNote{
    
    
    NSLog(@"note saved");
    
    NSString * serverString = [[NSString alloc]initWithFormat:@"http://%@:%@@104.131.225.142/cpbbackend/cakephp/notes.json",_userNameString,_userPasswordString];
    
    
    // Note that the URL is the "action" URL parameter from the form.
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:serverString]];
    [request setHTTPMethod:@"POST"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"content-type"];
    NSString *postString =[[NSString alloc]initWithFormat:@"data[Note][description]=%@&data[Note][title]=%@", self.noteDescriptionView.text,self.noteTitleView.text];
    NSData *data = [postString dataUsingEncoding:NSUTF8StringEncoding];
    [request setHTTPBody:data];
    [request setValue:[NSString stringWithFormat:@"%u", [data length]] forHTTPHeaderField:@"Content-Length"];
    [NSURLConnection connectionWithRequest:request delegate:self];
    
    

    
}


@end
