//
//  DetailViewController.m
//  NoteViewer
//
//  Created by Evan Spielberg on 8/4/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import "DetailViewController.h"

@interface DetailViewController ()
- (void)configureView;
@end

@implementation DetailViewController
@synthesize noteDictionary = _noteDictionary;
@synthesize noteTitleView = _noteTitleView;

#pragma mark - Managing the detail item

- (void)configureView
{
    // Update the user interface for the detail item.

    if (self.noteDictionary) {
        self.noteTitleView.text = [self.noteDictionary objectForKey:@"title"];
        self.noteDescriptionView.text = [self.noteDictionary objectForKey:@"description"];
    }
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    [self configureView];
    
    
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
- (IBAction)saveEditsButtonClicked:(UIButton *)sender {
    
    //For a real project we'd change this to a more secure method
    NSString * serverString = [[NSString alloc]initWithFormat:@"http://%@:%@@104.131.225.142/cpbbackend/cakephp/notes.json",_userNameString,_userPasswordString];
    
    
    // Note that the URL is the "action" URL parameter from the form.
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:serverString]];
    [request setHTTPMethod:@"POST"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"content-type"];
    NSString *postString =[[NSString alloc]initWithFormat:@"data[Note][description]=%@&data[Note][title]=%@&data[Note][id]=%@", self.noteDescriptionView.text,self.noteTitleView.text,[self.noteDictionary objectForKey:@"id"]];
    NSData *data = [postString dataUsingEncoding:NSUTF8StringEncoding];
    [request setHTTPBody:data];
    [request setValue:[NSString stringWithFormat:@"%lu", (unsigned long)[data length]] forHTTPHeaderField:@"Content-Length"];
    [NSURLConnection connectionWithRequest:request delegate:self];
    
 
}



-(void)setDictionary:(NSDictionary *) dict{
    self.noteDictionary =dict;
}



- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.noteTitleView resignFirstResponder];
    [self.noteDescriptionView resignFirstResponder];
   
}



- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    [self deleteNote];
    
}

-(void)doneWithUserNotesDescriptionField{
    //  NSString *textFromTheKeyboard = self.userNameTextField.text;
    //  NSLog(@"Weight = %@",textFromTheKeyboard);
    [self.noteDescriptionView resignFirstResponder];
}

-(void)doneWithUserNotesTitleField{
    [self.noteTitleView resignFirstResponder];
}
-(void)deleteNote{
    NSString * serverString = [[NSString alloc]initWithFormat:@"http://%@:%@@104.131.225.142/cpbbackend/cakephp/notes/%@.json",_userNameString,_userPasswordString,[self.noteDictionary objectForKey:@"id"]];
    
    // Note that the URL is the "action" URL parameter from the form.
    NSMutableURLRequest *request = [NSMutableURLRequest requestWithURL:[NSURL URLWithString:serverString]];
    [request setHTTPMethod:@"DELETE"];
    [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"content-type"];
    NSString *postString =[[NSString alloc]initWithFormat:@"data[Note][id]=%@",[self.noteDictionary objectForKey:@"id"]];
    NSData *data = [postString dataUsingEncoding:NSUTF8StringEncoding];
    [request setHTTPBody:data];
    [request setValue:[NSString stringWithFormat:@"%lu", (unsigned long)[data length]] forHTTPHeaderField:@"Content-Length"];
  [NSURLConnection connectionWithRequest:request delegate:self];
}

@end
