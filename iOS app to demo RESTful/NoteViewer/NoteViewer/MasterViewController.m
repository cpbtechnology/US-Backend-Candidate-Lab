//
//  MasterViewController.m
//  NoteViewer
//
//  Created by Evan Spielberg on 8/4/14.
//  Copyright (c) 2014 Evan Spielberg. All rights reserved.
//

#import "MasterViewController.h"

#import "DetailViewController.h"

#import "Reachability.h"

@interface MasterViewController () {
    NSMutableArray *_objects;
}
@end

@implementation MasterViewController
@synthesize userNameString = _userNameString;
@synthesize userIDString = _userIDString;
@synthesize userPasswordString = _userPasswordString;
@synthesize tableView = _tableView;
//@synthesize allNotesDictionary = _allNotesDictionary;
@synthesize allNotesArray = _allNotesArray;

NSString *const serverURL = @"localhost:8888/US-Backend-Candidate-Lab/cakephp/";
//NSString *const viewNotesURL = @"localhost:8888/US-Backend-Candidate-Lab/cakephp/notes/";

- (void)awakeFromNib
{
    [super awakeFromNib];
}

- (void)viewDidLoad
{
    [super viewDidLoad];
	// Do any additional setup after loading the view, typically from a nib.
    
    /*
    *Commented out default code
    self.navigationItem.leftBarButtonItem = self.editButtonItem;

    UIBarButtonItem *addButton = [[UIBarButtonItem alloc] initWithBarButtonSystemItem:UIBarButtonSystemItemAdd target:self action:@selector(insertNewObject:)];
    self.navigationItem.rightBarButtonItem = addButton;
    */
    _userNameString = [[NSString alloc]init];
    _userIDString = [[NSString alloc]init];
    _userPasswordString = [[NSString alloc]init];
   // _allNotesDictionary = [[NSDictionary alloc]init];
    _allNotesArray = [[NSArray alloc]init];


    //Pull JSON Listing all notes from the server
    [self loadJSONAndTableArrays];
   

    

}


- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)insertNewObject:(id)sender
{
    if (!_objects) {
        _objects = [[NSMutableArray alloc] init];
    }
    [_objects insertObject:[NSDate date] atIndex:0];
    NSIndexPath *indexPath = [NSIndexPath indexPathForRow:0 inSection:0];
    [self.tableView insertRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationAutomatic];
}

#pragma mark - Table View

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 1;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    //return _objects.count;
    return [_allNotesArray count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:@"Cell" forIndexPath:indexPath];

    NSDictionary *noteDictAtIndex = [_allNotesArray objectAtIndex:indexPath.row];
    NSDictionary *noteAtIndex =[noteDictAtIndex objectForKey:@"Note"];

    cell.textLabel.text = [noteAtIndex objectForKey:@"title"];
    return cell;
}

- (BOOL)tableView:(UITableView *)tableView canEditRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the specified item to be editable.
    return YES;
}

- (void)tableView:(UITableView *)tableView commitEditingStyle:(UITableViewCellEditingStyle)editingStyle forRowAtIndexPath:(NSIndexPath *)indexPath
{
    if (editingStyle == UITableViewCellEditingStyleDelete) {
        [_objects removeObjectAtIndex:indexPath.row];
        [tableView deleteRowsAtIndexPaths:@[indexPath] withRowAnimation:UITableViewRowAnimationFade];
    } else if (editingStyle == UITableViewCellEditingStyleInsert) {
        // Create a new instance of the appropriate class, insert it into the array, and add a new row to the table view.
    }
}

/*
// Override to support rearranging the table view.
- (void)tableView:(UITableView *)tableView moveRowAtIndexPath:(NSIndexPath *)fromIndexPath toIndexPath:(NSIndexPath *)toIndexPath
{
}
*/

/*
// Override to support conditional rearranging of the table view.
- (BOOL)tableView:(UITableView *)tableView canMoveRowAtIndexPath:(NSIndexPath *)indexPath
{
    // Return NO if you do not want the item to be re-orderable.
    return YES;
}
*/

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender
{
    if ([[segue identifier] isEqualToString:@"showDetail"]) {
        NSIndexPath *indexPath = [self.tableView indexPathForSelectedRow];
//        NSDate *object = _objects[indexPath.row];
//        [[segue destinationViewController] setDetailItem:object];
        NSDictionary *noteDictAtIndex =[_allNotesArray objectAtIndex:indexPath.row];
        NSDictionary *noteAtIndex =[noteDictAtIndex objectForKey:@"Note"];
        [[segue destinationViewController] setDictionary:noteAtIndex];
        

    }
}




-(void)loadJSONAndTableArrays{
    NSError* serverStringError = nil;
    //For a real project we'd change this to a more secure method
    NSString * serverString = [[NSString alloc]initWithFormat:@"http://%@:%@@%@notes.json",_userNameString,_userPasswordString,serverURL];
    
    //NSLog(@"loginStrWithCredentials = %@",loginStrWithCredentials);
    NSURL *urlServerJS= [[NSURL alloc] initWithString:serverString];
    [UIApplication sharedApplication].networkActivityIndicatorVisible = YES;
    NSString *  serverJsonStr = [NSString stringWithContentsOfURL: urlServerJS encoding:NSUTF8StringEncoding error:&serverStringError];
    [UIApplication sharedApplication].networkActivityIndicatorVisible = NO;
    NSData* serverJsonData = [serverJsonStr dataUsingEncoding:NSUTF8StringEncoding];
    
    NSError* error;
    NSDictionary* json = [NSJSONSerialization
                          JSONObjectWithData:serverJsonData
                          options:kNilOptions
                          error:&error];
    //_allNotesDictionary = [json objectForKey:@"notes"];
    _allNotesArray =[json objectForKey:@"notes"];
    NSLog(@"Loading Notes Data");
     [_tableView reloadData];
    
//    NSLog(@"allnotesarray = %@",_allNotesArray);


}

-(BOOL)connected
{
    Reachability *hostReachability = [Reachability reachabilityForInternetConnection];
    NetworkStatus networkStatus = [hostReachability currentReachabilityStatus];
    return !(networkStatus == NotReachable);
}
- (IBAction)unwindAndDelete:(UIStoryboardSegue*) unwindSegue{
    [self loadJSONAndTableArrays];
   // [_tableView reloadData];
    //NSLog(@"unwound");
    
}
@end
