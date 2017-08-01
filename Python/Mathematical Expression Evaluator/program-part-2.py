class implementation:

    def evaluate(self, value):                                          # evaluate() method distinguishes the value and
                                                                        # sends it to the correct method to handle it
        try :
            if value.get('variable'):                                   # if the value contains the field 'variable'
                return dict[value['variable']]                          # search dictionary for index that is equal to
        except: pass                                                    # the variable and return the value
        try:
            if value.get('operator'):                                   # if the value contains the field 'operator'

                op = value['operator']

                if op == 'set':
                    return self.evalSet(value)                          # check 'operator' field and send value to
                elif op == 'tuple':                                     # corresponding method for correct evaluation
                    return self.evalTuple(value)
                elif op == 'equal':
                    return self.evalEqual(value)
                elif op == 'member':
                    return self.evalMember(value)
                elif op == 'is-function':
                    return self.evalIsFunction(value)
                elif op == 'apply-function':
                    return self.evalApplyFunction(value)
                elif op == 'union':
                    return self.evalUnion(value)
                elif op == 'set-difference':
                    return self.evalDifference(value)
                elif op == 'intersection':
                    return self.evalIntersection(value)
                elif op == 'domain':
                    return self.evalDomain(value)
                elif op == 'inverse':
                    return self.evalInverse(value)
                elif op == 'diagonalize':
                    return self.evalDiagonalize(value)
        except: pass
        try:
            if isinstance( value, int):                                 # if value is of type int
                return value                                            # return the value
        except: pass

        return ('undefined!')                                           # value is unrecognised, return 'undefined'

    def evalSet(self, value):                                           # evalSet() method used for evaluating sets

        children = []
        argList = []                                                    # list to keep track of arguments and prevent duplicates

        for arg in value['arguments']:                                  # for each value in the set

            if arg not in argList:                                      # if the value doesn't exist in argList
                argList.append(arg)                                     # add to arglist
                children.append(self.evaluate(arg))                     # evaluate value and add to children

        return children                                                 # return list of evaluated values

    def evalTuple(self, value):                                         # evalTuple() method used for evaluating tuples
        c = []

        for arg in value['arguments']:                                  # for each value in the  tuple
            c.append((self.evaluate(arg)))                              # evaluate value and add to c

        children = (c[0],c[1])                                          # create tuple containing first two elements of c
        return children                                                 # return tuple of evaluated values

    def evalEqual(self, value):                                         # evalEqual() method used for evaluating equal function

        list = value['arguments']                                       # copy list of arguments to 'list'
        var = self.evaluate(list[0])                                    # evaluate the variable and set it to var
        val = self.evaluate(list[1])                                    # set val to the value to check

        if var == val:                                                  # if the value in var is equal to the value in val
            return 1                                                    # return 1 for true
        else:
            return 0                                                    # return 0 for false

    def evalMember(self, value):                                        # evalMember() used for evaluating member function

        list = value['arguments']                                       # copy list of arguments to 'list'
        var = self.evaluate(list[0])                                    # evaluate the variable and set it to var
        val = self.evaluate(list[1])                                    # set val to the value to check

        if var in val:                                                  # if the value in val contains the value in var
            return 1                                                    # return 1 for true
        else:
            return 0

    def evalIsFunction(self, value):                                    # evalIsFunction() method used for checking if-
                                                                        # expression is a function
        func = self.evaluate(value['arguments'][0])                     # first argument evaluated is the function
        td = {}                                                         # an empty dictionary

        for e in func:                                                  # for each element in 'func'
            if isinstance(e, tuple):                                    # if  element is a tuple
                    if not e[0] in td.keys():                           # if  left side of tuple is not a key in 'td'
                        td[e[0]] = e[1]                                 # add right side to 'td' with left side as key
                    else:                                               # else if it already exists
                        if td[e[0]] != e[1]:                            # if value in 'td' is not equal to right side
                            return 0                                    # expression is not a function
            else:                                                       # else if the element is not a tuple
                return 0                                                # expression is not a function
        return 1                                                        # no more elements in 'func', expression is a function

    def evalApplyFunction(self, value):                                 # evalApplyFunction() method used to apply-
                                                                        # expression to a function
        func = self.evaluate(value['arguments'][0])                     # first argument evaluated is the function
        var = self.evaluate(value['arguments'][1])                      # second argument evaluated is the variable

        td = {}                                                         # an empty dictionary
        val = 0                                                         # value given by applying function
        ind = 0                                                         # indicator if at least 1 valid pair is found

        if self.evalIsFunction(value):                                  # check if first argument of value is a function
            for pair in func:                                           # for each pair in the function
                if (pair[0] == var):                                    # if the left side is equal to 'var'
                    ind = 1                                             # set 'ind' to 1, signifying at least 1 valid pair
                    val = pair[1]                                       # set 'val' equal to right side of pair
                    if not var in td.keys():                            # if 'var' does not exist as a key in 'td'
                        td[var] = val                                   # add 'var' to 'td' as key with 'val' as value
                    else:                                               # else if it already exists
                        if td[var] != val:                              # if value in 'td' is not equal to 'val'
                            return ('undefined!')                       # return undefined
            if (ind == 0):                                              # if no valid pair was found
                return ('undefined!')                                   # return undefined
            return val                                                  # return 'val' if method is executed successfully
        return ('undefined!')                                           # if 'func' is not a function, return undefined

    def evalUnion(self, value):                                         # evalUnion() method for producing union of two sets

        set1 = self.evaluate(value['arguments'][0])
        set2 = self.evaluate(value['arguments'][1])

        union = []

        for e1 in set1:                                                 # for each element1 in 'set 1'
            for e2 in set2:                                             # for each element2 in 'set 2'
                if not e2 in union:                                     # if element2 is not in 'union'
                    union.append(e2)                                    # add element2 to 'union'
            if not e1 in union:                                         # if element1 is not in 'union'
                    union.append(e1)                                    # add element1 to 'union'
        return union                                                    # return union of the two sets

    def evalDifference(self, value):                                    # evalDifference() method for producing-
                                                                        # difference of two sets
        set1 = self.evaluate(value['arguments'][0])
        set2 = self.evaluate(value['arguments'][1])

        diff = []

        for e in set1:                                                  # for each element in 'set 1'
            if e not in set2:                                           # if element is not in 'set 2'
                diff.append(e)                                          # add element to 'diff'
        return diff                                                     # return difference of two sets

    def evalIntersection(self, value):                                  # evalIntersection() method for producing-
                                                                        # intersection of two sets
        set1 = self.evaluate(value['arguments'][0])
        set2 = self.evaluate(value['arguments'][1])

        inter = []

        for e1 in set1:                                                 # for each element1 in 'set 1'
            for e2 in set2:                                             # for each element2 in 'set 2'
                if e1 == e2:                                            # if element1 equals element2
                    inter.append(e1)                                    # add element1 to 'inter'
        return inter                                                    # return intersection of two sets

    def evalDomain(self, value):                                        # evalDomain() method for producing domain
                                                                        # of a function or set of ordered pairs
        set = self.evaluate(value['arguments'][0])

        dom = []

        for pair in set:                                                # for each pair in 'set'
            if not pair[0] in dom:                                      # if the left side of pair is not in 'dom'
                dom.append(pair[0])                                     # add left side to 'dom'
        return dom                                                      # return domain of function or set of ordered pairs

    def evalInverse(self, value):                                       # evalInverse() method for producing inverse
                                                                        # of a function
        set = self.evaluate(value['arguments'][0])

        inv = []

        if self.evalIsFunction(value):                                  # if the first argument of 'value' is a function
            for pair in set:                                            # for each pair in 'set'
                switch = (pair[1], pair[0])                             # switch left side and right side
                inv.append(switch)                                      # add switched pair to 'inv'
            return inv                                                  # return inverse of function
        return ('undefined!')                                           # return undefined if not a function

    def evalDiagonalize(self, value):                                   # evalDiagonalize() method used to diagonalize-
                                                                        # expressions and return a function
        args = value['arguments']

        if len(args) != 4:                                              # if there are not 4 arguments
            return ('undefined!')                                       # return undefined

        V1 = self.evaluate(args[0])                                     # 'V1' equals the evaluated first argument
        V2 = self.evaluate(args[1])                                     # 'V2' equals the evaluated second argument
        V3 = self.evaluate(args[2])                                     # 'V3' equals the evaluated third argument
        V4 = self.evaluate(args[3])                                     # 'V4' equals the evaluated fourth argument

        F = []                                                          # empty set 'F' for holding results

        for e1 in V1:                                                   # for each element1 in 'V1'
            for p2 in V2:                                               # for each pair2 in 'V2'
                if p2[0] == e1:                                         # if the left side of pair2 equals element1
                    for p2r in p2[1]:                                   # for each pair2r in the right side of pair2
                        if p2r[0] == e1:                                # if the left side of pair2r equals element1
                            V2r =  p2r[1]                               # set 'V2r' to the right side of pair2r
            if V2r == 'undefined!':                                     # if 'V2r' is undefined
                F.append((e1, V4))                                      # add tuple of element 1 and 'V4' to 'F'
            else:                                                       # else if 'V2r' is not undefined
                for p3 in V3:                                           # for each pair3 in 'V3'
                    if V2r == p3[0]:                                    # if 'V2r' equals the left side of pair3
                        V3r =  p3[1]                                    # set 'V3r' equal to the right side of pair 3
                if V3r != 'undefined':                                  # if 'V3r' is not undefined
                    F.append((e1, V3r))                                 # add tuple of element1 and 'V3r' to 'F'

        return F                                                        # return resulting function of diagonalization

    def outIterate (self, value):                                       # outIterate() method used to recurse through
                                                                        # lists and tuples and write to file
        i = 1

        for e in value:                                                 # for each element in the list/tuple
            if i < len(value):                                          # if it is not the last element in the list/tuple
                if self.outForm(e) is not None:
                    outF.write(self.outForm(e))                         # write to file the result of formatting the element
                outF.write(", ")                                        # write a comma to seperate current element from the next
                i += 1
            else:                                                       # if the element is the last in the list/tuple
                if self.outForm(e) is not None:
                    outF.write(self.outForm(e))                         # write to file the result of formatting the element


    def outForm (self, value):                                          # outForm() method used to format the evaluated values
                                                                        # for writing to file
            if isinstance (value, list):                                # if the value is of type list
                outF.write ('{')
                self.outIterate(value)                                  # send value to outIterate() to format elements in
                outF.write ('}')                                        # list and print braces around the elements
                return
            elif isinstance (value, tuple):                             # if the value is of type tuple
                    outF.write ("(")
                    self.outIterate(value)                              # send value to outIterate() to format elements in
                    outF.write(")")                                     # tuple and print brackets around the elements
                    return
            else:
                outF.write(str(value))                                  # element must be an integer, cast to string and
                                                                        # write to file

import json

f = open("input.json")                                                  # open json file
outF = open("output.txt", "w")                                          # create file for writing output to
data = json.load(f)                                                     # set 'data' to data in Json file

dict = dict()                                                           # create dictionary object for storing variables and values
imp = implementation()

for obj in data['declaration-list']:                                    # for each object in the declaration list

    key = obj['declared-variable']                                      # set key equal to the variable name, used as an index in the dictionary
    dict[key] = imp.evaluate(obj['value'])                              # evaluate the value and assign it to the key in the dictionary
    outF.write("let ")
    outF.write((key))
    outF.write(" be ")
    (imp.outForm(dict[key]))                                            # output to file and call method to format the evaluated value
    outF.write(";\n")